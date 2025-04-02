<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashbaordStoreController extends Controller
{
    //

    public function index($store_id = null)
    {
        $store = Store::find($store_id);
        //  dd(Auth()->user()->store);
        return view('store_dashboard.index', compact('store'));
    }


}