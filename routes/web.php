<?php

use App\Http\Controllers\CreateStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\store\StoreController;
use App\Http\Controllers\store_dashbaord\DashbaordStoreController;
use App\Http\Controllers\store_dashbaord\ManageCategoriesController;
use App\Http\Controllers\store_dashbaord\ManageProductsController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    session(['store_home' => route('welcome')]);

    return view('welcome');
})->name('welcome');

Route::get('/اسامة', function () {
    return view('store_create.os');
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', [HomeController::class, 'logout'])->middleware('auth')->name('logout');
// Route::post('/login', [HomeController::class, 'login'])->middleware('auth')->name('login');
Route::middleware(['auth'])->group(function () {
    
Route::get('/templates', [CreateStoreController::class, 'templates'])->name('templates');
Route::get('/template/show/{template_id}/{page_name}', [CreateStoreController::class, 'template_show'])->name('template.show');
Route::get('/store/create/view/{template_id}', [CreateStoreController::class, 'store_create_view'])->name('store.create.view');
Route::post('/store/create', [CreateStoreController::class, 'store_create'])->name('store.create');
Route::get('/store/settings/{store_id}', [CreateStoreController::class, 'store_settings_view'])->name('store.settings.view');
Route::post('/store/settings', [CreateStoreController::class, 'store_settings'])->name('store.settings');

Route::get('/dashboard/{store_id}', [DashbaordStoreController::class, 'index'])->name('dashboard.index')->middleware('store');
Route::get('/management/products/{store_id}', [ManageProductsController::class, 'index'])->name('manage.products');
Route::get('/product/create/{store_id}', [ManageProductsController::class, 'product_create_view'])->name('product.create.view');
Route::post('/product/create', [ManageProductsController::class, 'product_create'])->name('product.ceate');


Route::get('/management/categories/{store_id}', [ManageCategoriesController::class, 'index'])->name('manage.categories');
Route::get('/category/create/{store_id}', [ManageCategoriesController::class, 'category_create_view'])->name('category.create.view');
Route::post('/category/create', [ManageCategoriesController::class, 'category_create'])->name('category.create');
Route::get('/category/edit/{category_id}', [ManageCategoriesController::class, 'category_edit_view'])->name('category.edit.view');
Route::post('/category/edit', [ManageCategoriesController::class, 'category_edit'])->name('category.edit');
Route::get('/category/delete/{category_id}', [ManageCategoriesController::class, 'category_delete'])->name('category.delete');


Route::get('/support/create/{store_id}', [CreateStoreController::class, 'support_create_view'])->name('support.create.view');
Route::post('/support/create/{store_id}', [CreateStoreController::class, 'support_create'])->name('support.create');

Route::get('/conditions/create/{store_id}', [CreateStoreController::class, 'conditions_create_view'])->name('conditions.create.view');
Route::post('/conditions/create/{store_id}', [CreateStoreController::class, 'conditions_create'])->name('conditions.create');

});
Route::get('/store/{name}', [StoreController::class, 'home_store'])->name('home_store');
Route::get('/store/{name}/products/{category_id?}', [StoreController::class, 'products'])->name('products');
Route::get('/store/{name}/conditions', [StoreController::class, 'conditions'])->name('conditions');