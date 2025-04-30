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
    }
    public function product_edit_view($store_id, $product_id)
    {
    
        try {
            $store = Store::findOrFail($store_id);
            $product = Product::findOrFail($product_id);
            $categories = Category::where('store_id', $store_id)->get();

            return view('store_dashboard.products_update', compact('product', 'store', 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'تعذر العثور على المنتج أو المتجر.');
        }
    }
    public function product_edit(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'يرجى إدخال اسم المنتج.',
            'price.required' => 'يرجى إدخال السعر.',
            'price.numeric' => 'سعر المنتج يجب أن يكون رقم.',
            'category_id.required' => 'يرجى اختيار قسم.',
        ]);

        try {
            $product = Product::findOrFail($request->product_id);

            // حذف الصورة القديمة إذا تم رفع صورة جديدة
            if ($request->hasFile('image')) {
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }

                $imageName = Str::uuid()->toString() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/products'), $imageName);
                $product->image = 'assets/products/' . $imageName;
            }

            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->save();

            return redirect()->route('manage.products', $product->category->store_id)->with('success', 'تم تعديل المنتج بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'حدث خطأ أثناء تعديل المنتج: ' . $e->getMessage()])->withInput();
        }
    }
    public function product_delete($store_id,$product_id)
    {
        try {
            $product = Product::findOrFail($product_id);

            // حذف الصورة من السيرفر
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
            return redirect()->route('manage.products', $store_id)->with('success', 'تم حذف المنتج بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف المنتج: ' . $e->getMessage());
        }
    }
}
