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
        $end_date = $store->created_at->copy()->addDays(30); // نهاية التجربة المجانية
        $now = now();
        $diff_days = $now->diffInDays($end_date, false);
        $diff_hours = $now->diffInHours($end_date, false) % 24;
        if ($diff_days < 0 && $diff_hours < 0) {
        }
        return view('store_dashboard.index', compact('store', 'diff_days', 'diff_hours', 'end_date'));
    }
    function stores() {
        $user = Auth::user();
        $allStores = collect([$user->store])
            ->filter()
            ->merge($user->stores)
            ->unique('id');
    
        if ($allStores->isEmpty()) {
            return redirect('/')->with('success', 'لا يوجد لديك متاجر');
        }
    
        return view('stores', compact('allStores'));
    }

   

   
}
