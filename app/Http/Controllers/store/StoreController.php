<?php

namespace App\Http\Controllers\store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // تعريف الخصائص التي سيتم مشاركتها بين الدوال
    protected $store;
    protected $template;
    protected $languages;

    /**
     * دالة البناء: تقوم بتحميل بيانات المتجر ومسار القالب واللغات.
     */
    public function __construct(Request $request)
    {
        try {
            $this->middleware('check.store.active');
            // إذا وُجد اسم المتجر في الرابط (route)، نقوم بتحميل بياناته
            if ($request->route('name')) {
                $this->store = Store::with(['template', 'categories', 'languages'])
                    ->where('name', $request->route('name'))
                    ->firstOrFail();
                   
                // استخراج مسار القالب
                $this->template = $this->store->template->path_temp;

                // تخزين اللغات المتوفرة للمتجر
                $this->languages = $this->store->languages;

                // تحديد اللغة الافتراضية للمتجر
                $defaultLang = $this->languages->first()->code ?? 'ar';

                // إذا كان المتجر يحتوي على لغة واحدة، اجعلها لغة الجلسة
                if ($this->languages->count() < 2) {
                    session(['locale' => $defaultLang]);
                }

                // تعيين اللغة النشطة للتطبيق
                app()->setLocale(session('locale', $defaultLang));
            }
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ أثناء تحميل المتجر، نُظهر خطأ عام
            abort(404, 'المتجر غير موجود أو حدث خطأ.');
        }
    }

    /**
     * عرض الصفحة الرئيسية للمتجر.
     */
    public function home_store($name)
    {
        try {
            $store = $this->store;
            $template = $this->template;
            $languages = $this->languages;

            // جلب المنتجات الجديدة (آخر 3 منتجات من كل فئة)
            $new_products = $store->categories->flatMap(function ($category) {
                return Product::where('category_id', $category->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            });

            // تخزين رابط الصفحة الرئيسية في الجلسة
            session(['store_home' => route('home_store', ['name' => $store->name])]);

            // عرض صفحة القالب الرئيسي للمتجر
            return view("{$template}.welcome", compact('store', 'new_products', 'languages'));

        } catch (\Exception $e) {
            // في حالة حدوث خطأ غير متوقع
            return abort(500, 'حدث خطأ أثناء تحميل الصفحة الرئيسية للمتجر.');
        }
    }

    /**
     * عرض صفحة جميع المنتجات (حسب الفئة إن وُجدت).
     */
    public function products($name, $category_id = null)
    {
        return view("{$this->template}.products_all", [
            'store' => $this->store,
            'category_id' => $category_id,
            'languages' => $this->languages,
        ]);
    }
    public function search(Request $request, $name)
{
    // التحقق من وجود الكلمة المفتاحية
    $query = $request->input('name');

    // التأكد أن المتجر تم تحميله من __construct
    $store = $this->store;

    // البحث في منتجات المتجر بحسب الاسم أو الوصف
    $products = Product::whereHas('category', function($q) use ($store) {
            $q->whereIn('id', $store->categories->pluck('id'));
        })
        ->where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        }) 
        
        ->get();

    return view("{$this->template}.search_results", [
        'store' => $store,
        'products' => $products,
        'query' => $query,
        'languages' => $this->languages,
    ]);
}


    /**
     * عرض صفحة الشروط والأحكام الخاصة بالمتجر.
     */
    public function conditions($name)
    {
        return view("{$this->template}.conditions", [
            'store' => $this->store,
            'languages' => $this->languages,
        ]);
    }

    /**
     * عرض صفحة منتج مفرد.
     */
    public function single_product($name, $product_id)
    {
        try {
            // جلب المنتج بناءً على معرفه
            $product = Product::with('category')->where('id', $product_id)->firstOrFail();

            return view("{$this->template}.single_prod", [
                'store' => $this->store,
                'product' => $product,
                'languages' => $this->languages,
            ]);

        } catch (\Exception $e) {
            // في حال لم يتم العثور على المنتج
            return abort(404, 'المنتج غير موجود.');
        }
    }
}
