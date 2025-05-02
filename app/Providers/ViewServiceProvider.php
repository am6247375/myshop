<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Permission; // ✅ حرف كبير

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.master_store_admin', function ($view) {
            try {
                $user = Auth::user();
                $store = session('current_store'); // أو أي طريقة تجيب بها المتجر الحالي

                if ($user && $store) {
                    if ($user->store && $user->store->id == $store->id) {
                        $permissions = Permission::all();
                    } else {
                        $permissions = $user->permissions()->where('store_id', $store->id)->get();
                    }

                    $view->with('permissions', $permissions);
                }
            } catch (\Exception $e) {
                // يمكنك تسجيل الخطأ أو تجاهله حسب الحاجة
                $view->with('permissions', collect()); // تمرير قائمة فاضية لتفادي الأعطال
            }
        });
    }
}
