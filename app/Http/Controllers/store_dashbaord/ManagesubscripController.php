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
            'subscrip_id' => 'required|exists:subscriptions,id',
        ]);
    
        if (is_null($request->store_id) && is_null($user->store)) {
            return redirect()->route('templates')
                ->with('error', 'المستخدم ليس لديه متجر، الرجاء إنشاء متجر أولاً.');
        }
    
        $store = Store::findOrFail($request->store_id);
        $subscription = Subscription::findOrFail($request->subscrip_id);
    
        // تاريخ البدء الآن
        $start = now();
    
        // نحسب الأيام المتبقية (حتى لو سالب) من آخر اشتراك
        $latestSub = $store->latestSub();
        $remainingDays = 0;
    
        if ($latestSub) {
            $remainingDays = now()->diffInDays($latestSub->end_date, false);
            $remainingDays = max($remainingDays, 0); // نتأكد أنها ليست سالبة
        }
    
        // تاريخ النهاية = مدة الباقة + الأيام المتبقية (إن وجدت)
        $end = now()->addMonths($subscription->duration)->addDays($remainingDays);
    
        // إنشاء الاشتراك
        Subscriber::create([
            'store_id'    => $store->id,
            'subscrip_id' => $subscription->id,
            'start_date'  => $start,
            'end_date'    => $end,
        ]);
    
        $store->active = 1;
        $store->save();
    
        return redirect()->route('dashboard.index', ['store_id' => $store->id])
            ->with('success', 'تم الاشتراك في الباقة بنجاح، وتمت إضافة ' . $remainingDays . ' يوم من الاشتراك السابق 🎉');
    }    
}
