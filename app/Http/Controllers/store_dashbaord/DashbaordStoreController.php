<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Permission;
use App\Models\product;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
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
        if ($diff_days < 0 && $diff_hours < 0) {
        }
        return view('store_dashboard.index', compact('store', 'diff_days', 'diff_hours', 'end_date'));
    }


    public function Subscriber(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'subscrip_id' => 'required|exists:subscriptions,id',
        ]);
        

        $subscription = Subscription::findOrFail($request->subscrip_id);
        // dd($subscription);
        $start = Carbon::now();
        $end = Carbon::now()->addMonths($subscription->duration);

        Subscriber::create([
            'store_id' => $request->store_id,
            'subscrip_id' => $subscription->id,
            'start_date' => $start,
            'end_date' => $end,
        ]);

        return redirect()->route('dashboard.index', ['store_id' => $request->store_id])
            ->with('success', 'تم الاشتراك في الباقة بنجاح 🎉');
    }


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
}
