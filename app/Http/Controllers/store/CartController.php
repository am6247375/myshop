<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestOrders;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     // تعريف الخصائص التي سيتم مشاركتها بين الدوال
     protected $store;
     protected $template;
     protected $languages;
     protected $storeIsInactive = false; 

 
     /**
      * دالة البناء: تقوم بتحميل بيانات المتجر ومسار القالب واللغات.
      */
      public function __construct(Request $request)
      {
        $this->middleware('check.store.active');
          try {
              if ($request->route('name')) {
                  $this->store = Store::with(['template', 'categories', 'languages'])
                      ->where('name', $request->route('name'))
                      ->firstOrFail();
      
                
      
                  $this->template = $this->store->template->path_temp;
                  $this->languages = $this->store->languages;
                  $defaultLang = $this->languages->first()->code ?? 'ar';
      
                  if ($this->languages->count() < 2) {
                      session(['locale' => $defaultLang]);
                  }
      
                  app()->setLocale(session('locale', $defaultLang));
              }
          } catch (\Exception $e) {
              abort(404, 'المتجر غير موجود أو حدث خطأ.');
          }
      }
      
    public function cart_view($name)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $cart = Cart::where([
            'store_id' => $store->id,
            'user_id' => Auth::id()
        ])->with('product')->get();

        return view("{$store->template->path_temp}.cart", compact('store', 'cart'));
    }

    public function addcart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
        ]);

        $user_id = Auth::id();

        $cart = Cart::firstOrNew([
            'user_id' => $user_id,
            'product_id' => $request->product_id,
            'store_id' => $request->store_id,
        ]);

        $cart->quantity = $cart->exists ? $cart->quantity + 1 : 1;
        $cart->save();

        return redirect()->back()->with('success', 'تمت إضافة المنتج إلى السلة');
    }

    public function update_cart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
            'store_id' => 'required|exists:stores,id',
        ]);

        $cart = Cart::where('id', $request->cart_id)
            ->where('store_id', $request->store_id)
            ->firstOrFail();

        $cart->update(['quantity' => $request->quantity]);

        $cartItems = Cart::where([
            'user_id' => Auth::id(),
            'store_id' => $request->store_id
        ])->with('product')->get();

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $shipping = ($subtotal >= 250 || $subtotal == 0) ? 0 : 10;
        $total = $subtotal + $shipping;

        return response()->json([
            'success' => true,
            'newSubtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'newTotal' => number_format($total, 2),
        ]);
    }

    public function delete_cart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        Cart::where('id', $request->cart_id)->where('user_id', Auth::id())->delete();

        return redirect()->back()->with('message', 'تم حذف المنتج من السلة بنجاح');
    }

    public function checkout_view($name)
    {
        $user = Auth::user();
        $store = Store::with('template')->where('name', $name)->firstOrFail();

        $cart = Cart::where([
            'user_id' => $user->id,
            'store_id' => $store->id
        ])->with('product')->get();

        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'السلة فارغة.']);
        }

        return view("{$store->template->path_temp}.checkout", compact('store', 'cart'));
    }

    public function order_create(RequestOrders $request)
    {
        $user = Auth::user();
        $store = Store::findOrFail($request->store_id);

        $cart = Cart::where([
            'user_id' => $user->id,
            'store_id' => $store->id
        ])->with('product')->get();

        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'السلة فارغة.']);
        }

        $subtotal = $cart->sum(fn($item) => $item->quantity * $item->product->price);
        $shipping = ($subtotal >= 250 || $subtotal == 0) ? 0 : 10;

        $order = Order::create([
            'store_id' => $store->id,
            'customer_id' => $user->id,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'note' => $request->note,
            'status' => 'pending',
            'total_price' => $subtotal + $shipping,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total_price' => $item->quantity * $item->product->price,
            ]);
        }

        Cart::where('user_id', $user->id)->where('store_id', $store->id)->delete();

        return redirect()->route('show.orders', ['name' => $store->name])->with('success', 'تم إرسال الطلب بنجاح');
    }

    public function show_orders($name)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $orders = Order::with('orderItems.product')
            ->where([
                'customer_id' => Auth::id(),
                'store_id' => $store->id
            ])
            ->orderByDesc('created_at')
            ->get();

        return view("{$store->template->path_temp}.orders", compact('store', 'orders'));
    }
}
