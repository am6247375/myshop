<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\StoreManagement;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreManagMiddle
{
    public function handle(Request $request, Closure $next, $Permission=null)
    {
        $user = Auth::user();
   
        $store_id=$request->store_id;
        if ($user->store && $user->store->id == $store_id) {
            return $next($request);
        }
        $role = $user->roles()->where('store_id', $store_id)->exists();
        if (!$role) {
            return abort(403, 'ليس لديك الصلاحيات اللازمة   تنللو الوصول إلى هذه الصفحة.');

        }        
        $hasPermission = StoreManagement::where('store_id', $store_id)
            ->where('user_id', $user->id)
            ->whereHas('permission', function ($query) use ($Permission) {
                $query->where('name', $Permission);
            })
            ->exists();

        if (!$hasPermission) {
            return abort(403, 'ليس لديك الصلاحيات اللازمة للوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }
}
