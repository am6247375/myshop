<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    
    //   عرض الصفحة الرئيسية للمتجر.
    public function home_store($name)
    {
        // جلب بيانات المتجر مع القالب والفئات واللغات
        $store = Store::with(['template', 'categories', 'languages'])->where('name', $name)->firstOrFail();

        // تحديد اللغة الافتراضية للمتجر
        $defaultLang = $store->languages->first()->code ?? 'ar';

        // إذا كان المتجر يدعم لغة واحدة فقط، استخدمها دائمًا
        if ($store->languages->count() < 2) {
            session(['locale' => $defaultLang]);
        }

        // ضبط اللغة - احترام اللغة المحفوظة في الجلسة أو استخدام الافتراضية
        app()->setLocale(session('locale', $defaultLang));

        // جلب المنتجات الجديدة لكل فئة
        $new_products = $store->categories->flatMap(function ($category) {
            return Product::where('category_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        });

        // جلب اللغات المتاحة للمتجر
        $languages = $store->languages;

        // جلب مسار القالب
        $template = $store->template->path_temp;

        // تخزين رابط الصفحة الرئيسية للمتجر في الجلسة
        session(['store_home' => route('home_store', ['name' => $store->name])]);

        // عرض الصفحة الرئيسية باستخدام القالب المناسب
        return view("{$template}.welcome", compact('store', 'new_products', 'languages'));
    }

    /**
     * عرض صفحة المنتجات الخاصة بالمتجر.
     *
     * @param string $name اسم المتجر
     * @param int|null $category_id معرف الفئة (اختياري)
     * @return \Illuminate\View\View
     */
    public function products($name, $category_id = null)
    {
        // جلب بيانات المتجر مع القالب
        $store = Store::with('template')->where('name', $name)->firstOrFail();

        // جلب مسار القالب
        $template = $store->template->path_temp;

        // عرض صفحة المنتجات حسب الفئة إذا وُجدت
        return view($category_id ? "{$template}.products_all" : "{$template}.products_all", compact('store', 'category_id'));
    }
}
