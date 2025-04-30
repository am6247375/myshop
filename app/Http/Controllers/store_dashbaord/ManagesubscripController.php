<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Subscriber;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ManagesubscripController extends Controller
{
    //
    public function subscribe_view(Request $request)
    {
        $subscriptions = Subscription::all();
        $store_id = $request->store_id;
        return view('sub', compact('subscriptions', 'store_id'));
    }
    public function Subscriber(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'store_id'   => 'required|exists:stores,id',
            'subscrip_id'=> 'required|exists:subscriptions,id',
        ]);
        if (is_null($request->store_id) && is_null($user->store)) {
            return redirect()->route('templates')
                ->with('error', 'المستخدم ليس لديه متجر، الرجاء إنشاء متجر أولاً.');
        }
        // الحصول على معرف المتجر سواءً من الطلب أو من متجر المستخدم
        $storeId = $request->store_id;
        $store = Store::findOrFail($storeId);
        $subscription = Subscription::findOrFail($request->subscrip_id);
        $start = Carbon::now();
        $end = Carbon::now()->addMonths($subscription->duration);
    
        Subscriber::create([
            'store_id'   => $store->id,
            'subscrip_id'=> $subscription->id,
            'start_date' => $start,
            'end_date'   => $end,
        ]);
    
        $store->active = 1;
        $store->save();
        return redirect()->route('dashboard.index', ['store_id' => $store->id])
                         ->with('success', 'تم الاشتراك في الباقة بنجاح 🎉');
    }
    
}
