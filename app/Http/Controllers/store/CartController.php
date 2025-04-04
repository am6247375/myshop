<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
}
