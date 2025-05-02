<?php

use App\Http\Controllers\CreateStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\store\CartController;
use App\Http\Controllers\store\StoreController;
use App\Http\Controllers\store_dashbaord\DashbaordStoreController;
use App\Http\Controllers\store_dashbaord\ManageAdminController;
use App\Http\Controllers\store_dashbaord\ManageCategoriesController;
use App\Http\Controllers\store_dashbaord\ManageOrderController;
use App\Http\Controllers\store_dashbaord\ManageProductsController;
use App\Http\Controllers\store_dashbaord\ManagesubscripController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    session(['store_home' => route('welcome')]);
    return view('welcome');
})->name('welcome');

Route::get('/subscribe', [ManagesubscripController::class, 'subscribe_view'])->name('subscribe.view');
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

/*
|--------------------------------------------------------------------------
| روابط المصادقة (Authentication Routes)
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| الروابط المحمية (Protected Routes) - تتطلب تسجيل الدخول
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // مجموعة قوالب المتجر
    Route::prefix('/templates')->controller(CreateStoreController::class)->group(function () {
        Route::get('/', 'templates')->name('templates');
        Route::get('/show/{template_id}/{page_name}', 'template_show')->name('template.show');
    });

    // مجموعة إنشاء المتجر
    Route::prefix('/store')->controller(CreateStoreController::class)->group(function () {
        Route::get('/create/view/{template_id}', 'store_create_view')->name('store.create.view');
        Route::post('/create', 'store_create')->name('store.create');
        Route::get('/settings/{store_id}', 'store_settings_view')->name('store.settings.view');
        Route::post('/settings', 'store_settings')->name('store.settings');
    });

    // قائمة المتاجر للمستخدم
    Route::get('/stores', [DashbaordStoreController::class, 'stores'])->name('stores');

    // الاشتراك (Subscriber)
    Route::post('/subscribe/create', [ManagesubscripController::class, 'Subscriber'])->name('subscribe');

    /*
    |--------------------------------------------------------------------------
    | لوحة تحكم المتجر (Dashboard)
    |--------------------------------------------------------------------------
    */
    Route::prefix('/dashboard/{store_id}')->group(function () {
        Route::get('/', [DashbaordStoreController::class, 'index'])
            ->name('dashboard.index');
        // إدارة المنتجات
        Route::prefix('/management/products')->controller(ManageProductsController::class)
            ->middleware('store_manage:ادارة المنتجات')
            ->group(function () {
                Route::get('/', 'index')->name('manage.products');
                Route::get('/create', 'product_create_view')->name('product.create.view');
                Route::post('/create', 'product_create')->name('product.create');
                Route::get('/edit/{product_id}', 'product_edit_view')->name('product.edit.view');
                Route::post('/edit', 'product_edit')->name('product.edit');
                Route::get('/delete/{product_id}', 'product_delete')->name('product.delete');
            });

        // إدارة المشرفين (الموظفين)
        Route::prefix('/management/manage_admin')->controller(ManageAdminController::class)
            ->middleware('store_manage:ادارة الموظفين')
            ->group(function () {
                Route::get('/', 'manage_admin')->name('manage.admin');
                Route::get('/create', 'admin_create_view')->name('admin.create.view');
                Route::post('/created', 'admin_create')->name('admin.create');
                Route::get('/edit/{admin_id}', 'admin_edit_view')->name('admin.edit.view');
                Route::post('/edit', 'admin_edit')->name('admin.edit');
                Route::get('/delete/{admin_id}', 'admin_delete')->name('admin.delete');
            });

        // إدارة الأقسام
        Route::prefix('/management/categories')->controller(ManageCategoriesController::class)
            ->middleware('store_manage:ادارة الاقسام')
            ->group(function () {
                Route::get('/', 'index')->name('manage.categories');
                Route::get('/create', 'category_create_view')->name('category.create.view');
                Route::post('/create', 'category_create')->name('category.create');
                Route::get('/edit/{category_id}', 'category_edit_view')->name('category.edit.view');
                Route::post('/edit', 'category_edit')->name('category.edit');
                Route::get('/delete/{category_id}', 'category_delete')->name('category.delete');
            });


        Route::prefix('/management/settings')->controller(CreateStoreController::class)
            ->middleware('store_manage:ادارة الاعدادات')
            ->group(function () {
                Route::get('/', 'store_settings_view')->name('settings.create.view');
                Route::post('/create', 'settings')->name('settings.create');
            });

        Route::prefix('/conditions')->controller(CreateStoreController::class)
        ->middleware('store_manage:ادارة الصفحات القانونية')
        ->group(function () {
            Route::get('/create/', 'conditions_create_view')->name('conditions.create.view');
            Route::post('/createed', 'conditions_create')->name('conditions.create');
        });

        // إدارة الطلبات
        Route::prefix('/management/orders')->controller(ManageOrderController::class)
         ->middleware('store_manage:ادارة الطلبات')
            ->group(function () {
                Route::get('', 'orders_manage')->name('orders.manage');
                Route::get('/show/{order_id}', 'order_show')->name('order.show');
                Route::post('/update', 'order_update')->name('order.update');
                Route::get('/delete/{order_id}', 'order_delete')->name('order.delete');
            });
    });
});

/*
|--------------------------------------------------------------------------
| روابط المتجر العامة (Store Public Routes)
|--------------------------------------------------------------------------
*/
Route::prefix('/store')->controller(StoreController::class)->group(function () {
    Route::get('/{name}', 'home_store')->name('home_store');
    Route::get('/{name}/products/{category_id?}', 'products')->name('products');
    Route::get('/{name}/conditions', 'conditions')->name('conditions');
});

/*
|--------------------------------------------------------------------------
| روابط عربة التسوق والدفع (Cart & Checkout) - تتطلب تسجيل الدخول
|--------------------------------------------------------------------------
*/
Route::controller(CartController::class)->middleware('auth')->group(function () {
    Route::get('/store/{name}/cart', 'cart_view')->name('cart.view');
    Route::post('/store', 'addcart')->name('add.cart');
    Route::post('/store/cart/update', 'update_cart')->name('update.cart');
    Route::delete('/store/cart/delete', 'delete_cart')->name('delete.cart');
    Route::get('/store/{name}/checkout', 'checkout_view')->name('checkout.view');
    Route::post('/store/checkout', 'order_create')->name('checkout');
    Route::get('/store/{name}/orders', 'show_orders')->name('show.orders');
});
