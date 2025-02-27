<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function home_store($name)
    {
        $store = Store::with(['template', 'categories'])->where('name', $name)->firstOrFail();
        
        $new_products = [];
    
        foreach ($store->categories as $category) {
            $products = Product::where('category_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
            
            $new_products = array_merge($new_products, $products->toArray());
        }
        $template = $store->template->path_temp;
        session(['store_home' => route('home_store', ['name' => $store->name])]);
        return view($template . '.welcome', compact('store', 'new_products'));
        
    }
    public function products($name, $category_id = null)
    {
        $store = Store::with('template')->where('name', $name)->firstOrFail();
        $template = $store->template->path_temp;
        if ($category_id) {
            return view($template . '.products_all', compact('store', 'category_id'));
        }
        return view($template . '.products_all', compact('store'));
    }
}
