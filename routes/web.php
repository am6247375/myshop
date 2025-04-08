<?php

use App\Http\Controllers\CreateStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\store\CartController;
use App\Http\Controllers\store\StoreController;
use App\Http\Controllers\store_dashbaord\DashbaordStoreController;
use App\Http\Controllers\store_dashbaord\ManageAdminController;
use App\Http\Controllers\store_dashbaord\ManageCategoriesController;
use App\Http\Controllers\store_dashbaord\ManageProductsController;
use App\Models\Subscriber;
use App\Models\Subscription;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| روابط الويب
|--------------------------------------------------------------------------
|
| هنا يمكنك تسجيل روابط الويب لتطبيقك. يتم تحميل هذه الروابط
| عبر RouteServiceProvider ضمن مجموعة تحتوي على وسيط "web"
| الآن قم ببناء شيء رائع!
|
*/

// الروابط العامة (لا تتطلب تسجيل دخول)
Route::get('/', function () {
    session(['store_home' => route('welcome')]);
    return view('welcome');
})->name('welcome');
Route::get('/subscribe', function () {
    $subscriptions = Subscription::all();
    return view('sub', compact('subscriptions'));
})->name('subscribe');

// رابط تجريبي (ربما لأغراض التطوير)
Route::get('/اسامة', function () {
    return view('store_create.os');
});

// رابط تغيير اللغة
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang');
Route::get('/stores', function () {
    $user = Auth::user();
    $allStores = collect([$user->store])
        ->filter()
        ->merge($user->stores)
        ->unique('id');

    if ($allStores->isEmpty()) {
        return redirect('/')->with('success', 'لا يوجد لديك متاجر');
    }

    return view('stores', compact('allStores'));
})->middleware('auth')->name('stores');


// روابط المصادقة (تسجيل دخول، تسجيل حساب، إلخ)
Auth::routes();

// الرابط الرئيسي بعد المصادقة
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// الروابط التي تتطلب تسجيل الدخول
Route::middleware(['auth'])->group(function () {

    // رابط معاينة القالب
    Route::prefix('/templates')->controller(CreateStoreController::class)->group(function () {
        Route::get('/', 'templates')->name('templates');
        Route::get('/show/{template_id}/{page_name}', 'template_show')->name('template.show');
    });

    // روابط إنشاء المتجر 
    Route::prefix('/store')->controller(CreateStoreController::class)->group(function () {
        Route::get('/create/view/{template_id}', 'store_create_view')->name('store.create.view');
        Route::post('/create', 'store_create')->name('store.create');
        Route::get('/settings/{store_id}', 'store_settings_view')->name('store.settings.view');
        Route::post('/settings', 'store_settings')->name('store.settings');
    });

    // روابط لوحة تحكم المتجر
    Route::prefix('/dashboard')->group(function () {
        Route::get('/{store_id}', [DashbaordStoreController::class, 'index'])
            ->name('dashboard.index');
            Route::post('/subscribe/store',[ DashbaordStoreController::class, 'Subscriber'])->name('subscribe');

        // إدارة المنتجات
        Route::prefix('/management/products')->controller(ManageProductsController::class)
            ->middleware('store_manage:ادارة المنتجات')
            ->group(function () {
                Route::get('/{store_id}', 'index')->name('manage.products');
                Route::get('/create/{store_id}', 'product_create_view')->name('product.create.view');
                Route::post('/create', 'product_create')->name('product.create');
            });
        // إدارة المشرفين
        Route::prefix('/management/manage_admin')->controller(ManageAdminController::class)
            ->middleware('store_manage: الموظفين')
            ->group(function () {
                Route::get('/{store_id}', 'manage_admin')->name('manage.admin');
                Route::get('/{store_id}/create', 'admin_create_view')->name('admin.create.view');
                Route::post('/', 'admin_create')->name('admin.create');
                Route::get('/{store_id}/edit/{admin_id}', 'admin_edit_view')->name('admin.edit.view');
                Route::post('/edit', 'admin_edit')->name('admin.edit');
                Route::get('/{store_id}/delete/{admin_id}', 'admin_delete')->name('admin.delete');
            });

        // إدارة الأقسام
        Route::prefix('/management/categories')->controller(ManageCategoriesController::class)
            ->middleware('store_manage:ادارة الاقسام')
            ->group(function () {
                Route::get('/{store_id}', 'index')->name('manage.categories');
                Route::get('/create/{store_id}', 'category_create_view')->name('category.create.view');
                Route::post('/create', 'category_create')->name('category.create');
                Route::get('/edit/{category_id}', 'category_edit_view')->name('category.edit.view');
                Route::post('/edit', 'category_edit')->name('category.edit');
                Route::get('/delete/{category_id}', 'category_delete')->name('category.delete');
            });

        // الدعم والشروط
        Route::prefix('/support')->controller(CreateStoreController::class)
            ->middleware('store_manage:ادارة الاعدادات')
            ->group(function () {
                Route::get('/create/{store_id}', 'support_create_view')->name('support.create.view');
                Route::post('/create/{store_id}', 'support_create')->name('support.create');
            });

        Route::prefix('/conditions')->controller(CreateStoreController::class)->group(function () {
            Route::get('/create/{store_id}', 'conditions_create_view')->name('conditions.create.view');
            Route::post('/create/{store_id}', 'conditions_create')->name('conditions.create');
        });
        // إدارة الطلبات
        Route::prefix('/orders')->controller(DashbaordStoreController::class)
            ->group(function () {
                Route::get('/{store_id}', 'orders_manage')->name('orders.manage');
                Route::get('/{store_id}/show/{order_id}', 'order_show')->name('order.show');
                Route::post('/update', 'order_update')->name('order.update');
                Route::get('/delete/{order_id}', 'order_delete')->name('order.delete');
            });
    });
});

// روابط المتجر العامة
Route::prefix('/store')->controller(StoreController::class)->group(function () {
    Route::get('/{name}', 'home_store')->name('home_store');
    Route::get('/{name}/products/{category_id?}', 'products')->name('products');
    Route::get('/{name}/conditions', 'conditions')->name('conditions');
});
Route::controller(CartController::class)->middleware('auth')->group(function () {
    Route::get('/store/{name}/cart', 'cart_view')->name('cart.view');
    Route::post('/store', 'addcart')->name('add.cart');
    Route::post('/store/cart/update', 'update_cart')->name('update.cart');
    Route::delete('/store/cart/delete', 'delete_cart')->name('delete.cart');
    Route::get('/store/{name}/checkout', 'checkout_view')->name('checkout.view');
    Route::post('/store/checkout', 'order_create')->name('checkout');
    Route::get('/store/{name}/orders', 'show_orders')->name('show.orders');
});

