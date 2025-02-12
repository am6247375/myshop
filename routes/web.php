<?php

use App\Http\Controllers\CreateStore;
use App\Http\Controllers\store\StoreController;
use App\Http\Controllers\store_dashbaord\ManageCategoriesController;
use App\Http\Controllers\store_dashbaord\ManageProductsController;
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
    return view('welcome');
});

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


Route::get('/templates', [CreateStore::class, 'templates'])->name('templates');
Route::post('/store/create/view', [CreateStore::class, 'store_create_view'])->name('store.create.view');
Route::post('/store/create', [CreateStore::class, 'store_create'])->name('store.ceate');
Route::get('/store/{name}', [StoreController::class, 'home_store'])->name('home_store');


Route::get('/management/categories/{store_id}', [ManageCategoriesController::class, 'index'])->name('manage.categories');
Route::get('/category/create/{store_id}', [ManageCategoriesController::class, 'category_create_view'])->name('category.create.view');
Route::post('/category/create', [ManageCategoriesController::class, 'category_create'])->name('category.ceate');

Route::get('/management/products/{store_id}', [ManageProductsController::class, 'index'])->name('manage.products');
Route::get('/product/create/{store_id}', [ManageProductsController::class, 'product_create_view'])->name('product.create.view');
Route::post('/product/create', [ManageProductsController::class, 'product_create'])->name('product.ceate');
