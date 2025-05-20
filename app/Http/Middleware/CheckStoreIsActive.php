<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class CheckStoreIsActive
{
    public function handle(Request $request, Closure $next)
    {
        // جلب المعرف أو الاسم من الرابط
        $storeIdentifier = $request->route('store_id') ?? $request->route('name');
    
        if (!$storeIdentifier) {
            return $next($request); // لا يوجد معرف أو اسم متجر في الرابط
        }
    
        // جلب المتجر إما بالاسم أو المعرف
        $store = is_numeric($storeIdentifier)
            ? Store::find($storeIdentifier)
            : Store::where('name', $storeIdentifier)->first();
    
        // إذا لم يتم العثور على المتجر
        if (!$store) {
            return response()->view('error.general', [
                'statusCode' => 404,
                'errorMessage' => 'المتجر غير موجود.'
            ]);
        }
    
        // التحقق من حالة المتجر
        if ($this->checkStoreStatus($store)) {
            return response()->view('error.general', [
                'statusCode' => 403,
                'errorMessage' => 'هذا المتجر موقف مؤقتاً.'
            ]);
        }
    
        // تمرير المتجر للطلب
        $request->attributes->add(['store' => $store]);
    
        return $next($request);
    }
    
    /**
     * التحقق من حالة المتجر وتحديثه إذا لزم الأمر
     */
    protected function checkStoreStatus(Store $store): bool
    {
        $remaining = $store->remainingTime();
        $days = $remaining['days'];
        $hours = $remaining['hours'];
    
        // تحديث حالة التفعيل حسب الوقت المتبقي
        $store->active = ($days > 0 || $hours > 0) ? 1 : 0;
        $store->save();
    
        return !$store->active;
    }
    
    
}    
