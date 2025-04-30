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
    public function index($store_id = null)
    {
        $store = Store::find($store_id);
        $categories = category::where('store_id', $store_id)->get();
        return view('store_dashboard.manage_categories', compact('categories', 'store'));
    }

    public function category_create_view($store_id = null)
    {
        $store = Store::find($store_id);
        return view('store_dashboard.category_create', compact('store'));
    }

    public function category_create(Request $request)
    {
        try {
            // تحقق يدوي لعرض رسائل مخصصة
            if (!$request->name) {
                return back()->withErrors(['name' => 'يرجى إدخال اسم القسم.'])->withInput();
            }

            if (!$request->hasFile('image')) {
                return back()->withErrors(['image' => 'يرجى اختيار صورة للقسم.'])->withInput();
            }

            if (!$request->store_id) {
                return back()->withErrors(['store_id' => 'معرف المتجر مفقود.'])->withInput();
            }

            // حفظ الصورة
            $imageName = Str::uuid()->toString() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/category'), $imageName);

            // إنشاء القسم
            $category = new category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->image = 'assets/category/' . $imageName;
            $category->store_id = $request->store_id;
            $category->save();

            return redirect($request->previous_url)->with('success', 'تم إنشاء القسم بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'حدث خطأ أثناء إنشاء القسم: ' . $e->getMessage()])->withInput();
        }
    }

    public function category_edit_view($store_id = null, $category_id = null)
    {
        $store = Store::find($store_id);
        $category = category::find($category_id);
        return view('store_dashboard.category_update', compact('store', 'category'));
    }

    public function category_edit(Request $request)
    {
        try {
            if (!$request->name) {
                return back()->withErrors(['name' => 'يرجى إدخال اسم القسم.'])->withInput();
            }

            if (!$request->category_id) {
                return back()->withErrors(['category_id' => 'معرف القسم مفقود.'])->withInput();
            }

            if (!$request->store_id) {
                return back()->withErrors(['store_id' => 'معرف المتجر مفقود.'])->withInput();
            }

            $category = category::find($request->category_id);
            if (!$category) {
                return back()->withErrors(['category_id' => 'القسم غير موجود.'])->withInput();
            }

            // إذا تم رفع صورة جديدة
            if ($request->hasFile('image')) {
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $imageName = Str::uuid()->toString() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/category'), $imageName);
                $category->image = 'assets/category/' . $imageName;
            }

            // تحديث البيانات
            $category->name = $request->name;
            $category->description = $request->description;
            $category->store_id = $request->store_id;
            $category->save();

            return redirect()->route('manage.categories', $request->store_id)->with('success', 'تم تعديل القسم بنجاح');
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'حدث خطأ أثناء تعديل القسم: ' . $e->getMessage()])->withInput();
        }
    }
    public function category_delete($store_id, $category_id)
    {
        try {
            $category = category::find($category_id);

            if (!$category) {
                return redirect()->back()->withErrors(['general' => 'القسم غير موجود.']);
            }

            // حذف الصورة إن وجدت
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $category->delete();

            return redirect()->route('manage.categories', $store_id)->with('success', 'تم حذف القسم بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()]);
        }
    }
}
