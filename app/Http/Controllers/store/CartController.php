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
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cart_view($name)
    {
        // جلب بيانات المتجر مع القالب
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $cart = Cart::where(['store_id' => $store->id, 'user_id' => Auth::id()])->with('product')->get();
        $template = $store->template->path_temp;

        // عرض صفحة المنتجات حسب الفئة إذا وُجدت
        return view("{$template}.cart", compact('store', 'cart'));
    }
    public function addcart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            // 'store_id'=>'required'
        ]);
        $product_id = $request->product_id;
        $store_id = $request->store_id;
        $user_id = Auth::id();

        Cart::updateOrCreate(
            [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'store_id' => $store_id
            ],
            [
                'quantity' => DB::raw('COALESCE(quantity, 0) + 1') // إذا كان NULL، اجعله 0 ثم أضف 1
            ]
        );
        return redirect()->back()->with('message', 'تمت إضافة المنتج إلى السلة');
    }

    public function update_cart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
            'store_id' => 'required|exists:stores,id', // التحقق من وجود المتجر
        ]);

        $cart = Cart::where('id', $request->cart_id)
            ->where('store_id', $request->store_id) // التحقق من أن السلة تنتمي للمتجر
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        // حساب الإجماليات بناءً على `store_id`
        $cartItems = Cart::where('user_id', auth()->id())
            ->where('store_id', $request->store_id) // تصفية المنتجات لهذا المتجر
            ->get();

        $newSubtotal = 0;
        foreach ($cartItems as $item) {
            $newSubtotal += $item->quantity * $item->product->price;
        }
        $shipping = $newSubtotal >= 250 || $newSubtotal == 0 ? 0 : 10;
        // تكلفة الشحن يمكن أن تكون ديناميكية لكل متجر

        $newTotal = $newSubtotal + $shipping;
        return response()->json([
            'success' => true,
            'newSubtotal' => number_format($newSubtotal, 2),
            'shipping' => number_format($shipping, 2),
            'newTotal' => number_format($newTotal, 2),
        ]);
    }
    public function delete_cart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        Cart::find($request->cart_id)->delete();
        return redirect()->back()->with('message', 'تم حذف المنتج من السلة بنجاح');
    }


    public function checkout_view($name)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $cart = Cart::where(['store_id' => $store->id, 'user_id' => Auth::id()])->with('product')->get();
        $template = $store->template->path_temp;
        return view("{$template}.checkout", compact('store', 'cart'));
    }

    public function order_create(RequestOrders $request)
    {
        $user = Auth::user();
        $store_id = $request->store_id;
        $store = Store::findOrFail($store_id);
        $cart = Cart::where(['user_id' => $user->id, 'store_id' => $store_id])->with('product')->get();

        if (!$cart || $cart->isEmpty()) {
            return back()->withErrors(['cart' => 'السلة فارغة.']);
        }

        // احسب المجموع الفرعي
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item->quantity * $item->product->price;
        }

        // احسب الشحن
        $shipping = ($subtotal >= 250 || $subtotal == 0) ? 0 : 10;

        // أنشئ الطلب
        $order = Order::create([
            'store_id' => $store_id,
            'customer_id' => Auth::id(),
            'recipient_name' => $request->x,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'note' => $request->note,
            'status' => 'pending',
            'total_price' => $subtotal + $shipping,
            
        ]);

        
        // أضف عناصر الطلب
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total_price' => $item->quantity * $item->product->price,
            ]);
        }
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('show.orders',['name'=>$store->name])->with('success', 'تم إرسال الطلب بنجاح');
    }
    public function show_orders($name)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $orders=Order::with('orderItems')->where(['customer_id'=>Auth::id(),'store_id'=>$store->id]) ->orderBy('created_at', 'desc')->get();
        // $orders = Order::where(['customer_id'=>Auth::id(),'store_id'=>$store->id])
        //     ->with('orderItems.product') // علاقات العناصر والمنتجات
        //     ->orderBy('created_at', 'desc')
        //     ->get();
            $template = $store->template->path_temp;

        return view("{$template}.orders", compact('store','orders'));
    }
}
