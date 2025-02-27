<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageCategoriesController extends Controller
{
    public function index($store_id=null)
    {
        $store=Store::find($store_id);
        $categories = category::where('store_id', $store_id)->get();
        return view('store_dashboard.manage_categories', compact('categories','store',));
    }
    public function category_create_view($store_id=null)
    {
        $store=Store::find($store_id);
        return view('store_dashboard.category_create' , compact('store')); 
    }
    public function category_create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'store_id' => 'required',
        ]);
        $imageName = Str::uuid()->toString() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('assets/category'), $imageName);

        $category = new category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image ='assets/category/'. $imageName;
        $category->store_id = $request->store_id;
        $category->save();
        return redirect($request->previous_url, compact('store'))->with('success', 'تم إنشاء المنتج بنجاح');
        // return redirect()->back()->with('success', 'تم إنشاء القسم بنجاح');
    }

}
