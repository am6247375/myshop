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
{public function index($store_id = null)
    {
        try {
            // جلب المتجر المطلوب عبر الـ ID
            $store = Store::find($store_id);
    
            // حفظ المتجر في الجلسة ليُستخدم لاحقاً
            session(['current_store' => $store]);
    
            // عرض لوحة تحكم المتجر
            return view('store_dashboard.index', compact('store'));
        } catch (\Exception $e) {
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل المتجر.');
        }
    }
    
    public function stores()
    {
        try {
            $user = Auth::user();
    
            // دمج المتجر الرئيسي للمالك مع المتاجر التي يديرها
            $allStores = collect([$user->store])
                ->filter() // إزالة القيم null
                ->merge($user->stores) // دمج المتاجر التي يديرها
                ->unique('id'); // إزالة التكرارات حسب الـ ID
    
            // التحقق إذا ما كان المستخدم لا يملك أي متاجر
            if ($allStores->isEmpty()) {
                return redirect('/')->with('success', 'لا يوجد لديك متاجر');
            }
    
            // عرض صفحة اختيار المتاجر
            return view('stores', compact('allStores'));
        } catch (\Exception $e) {

    
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحميل المتاجر.');
        }
    }
    
}
