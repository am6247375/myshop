<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestManageProducts;
use App\Models\category;
use App\Models\product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageProductsController extends Controller

{
    public function index($store_id = null)
    {
        // التحقق من وجود المتجر
        if (!$store_id || !$store = Store::find($store_id)) {
            return redirect()->back()->with('error', 'المتجر غير موجود');
        }

        // جلب الفئات مع المنتجات المرتبطة بهذا المتجر
        $categories = Category::with('products')->where('store_id', $store_id)->get();

        return view('store_dashboard.manage_products', compact('categories', 'store'));
    }

    public function product_create_view($store_id = null)
    {
        $store = Store::find($store_id);
        $categories = Category::where('store_id', $store_id)->get();
        return view('store_dashboard.product_create', compact('categories', 'store'));
    }
    public function product_create(RequestManageProducts $request)
    {
        $imageName = Str::uuid()->toString() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('assets/products'), $imageName);

        $product = new product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = 'assets/products/' . $imageName;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect($request->previous_url)->with('success', 'تم إنشاء المنتج بنجاح');
        // return redirect()->b->with('success', 'تم إنشاء المنتج بنجاح');
    }
}
