<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;

class DashbaordStoreController extends Controller
{
    //
   
    public function index($store_id=null)
    {
        $store=Store::find($store_id);
//  dd(Auth()->user()->store);
        return view('store_dashboard.index', compact('store'));
    }
    

    public function manage_admin($store_id=null)
    {
        $store = Store::find($store_id);

        $admins = StoreManagement::where('store_id', $store_id)
            ->with(['role', 'permission', 'user'])
            ->get()
            ->groupBy('user_id'); // تجميع الإدخالات حسب المستخدم
        
        return view('store_dashboard.manage_admin', compact('admins', 'store'));
        
              
    }

}
