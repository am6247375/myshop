<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function home_store($name)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        // dd($store);
        $template = $store->template->path_temp;
        return view($template.'.welcome', compact('store'));
    }
}
