<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    public function orders_manage($store_id = null)
    {
        $store = Store::find($store_id);

        $orders = Order::where('store_id', $store_id)->get();
        return view('store_dashboard.orders_manage', compact('orders', 'store'));
    }
    public function order_show($store_id = null, $order_id = null)
    {
        $store = Store::find($store_id);
        $order = Order::where('id', $order_id)->with('orderItems')->first();
        return view('store_dashboard.order_show', compact('order', 'store'));
    }
    public function order_update(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order) {
            $order->status = $request->status;
            $order->user_id = Auth::id();
            $order->save();
            return  redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
        }
        return  redirect()->back()->with('success', 'حدث مشكلة اثناء تحديث حالة الطلب');
    }
    //
}
