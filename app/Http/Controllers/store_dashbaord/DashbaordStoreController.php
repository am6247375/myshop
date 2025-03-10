<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Store;
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
}
