<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Permission;
use App\Models\product;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashbaordStoreController extends Controller
{
    public function index($store_id = null)
    {
        $store = Store::find($store_id);
        $end_date = $store->created_at->copy()->addDays(1); // نهاية التجربة المجانية
        $now = now();
        $diff_days = $now->diffInDays($end_date, false);
        $diff_hours = $now->diffInHours($end_date, false) % 24;
        if($diff_days < 0 && $diff_hours < 0){
            
        }
        return view('store_dashboard.index', compact('store', 'diff_days', 'diff_hours', 'end_date'));
    }
    
    public function orders_manage($store_id = null)
    {
        $store = Store::find($store_id);
        
       $orders=Order::where('store_id',$store_id)->get();
        return view('store_dashboard.orders_manage', compact('orders', 'store'));
    }
    public function order_show($store_id = null, $order_id = null)
    {
        $store = Store::find($store_id);
        $order=Order::where('id',$order_id)->with('orderItems')->first();

        // dd($order);
        return view('store_dashboard.order_show', compact('order', 'store'));
    }
    public function order_update(Request $request)
    {
        $order=Order::find($request->order_id);
        if($order){
            $order->status=$request->status;
            $order->user_id=Auth::id();
            $order->save();
            return  redirect()->back()->with('success','تم تحديث حالة الطلب بنجاح');
        }
        return  redirect()->back()->with('success','حدث مشكلة اثناء تحديث حالة الطلب');

    }

}