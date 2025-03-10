<?php

namespace App\Http\Middleware;

use App\Models\Store;
use App\Models\StoreManagement;
use Closure;
use Illuminate\Http\Request;

class StoreManagMiddle
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth()->user();
        $store= Store::where('owner_id', $user->id)->first();
        $management = StoreManagement::where('user_id', $user->id)->first();
        // dd($management);
        if ($store||$management) {
            return $next($request);
        }
       
        // if ($management) {
        //     return view('store_dashboard.index', compact('store'));
        // }

        return response()->json(['message' => 'غير مسموح لك بالدخول'], 403);
    }
}
