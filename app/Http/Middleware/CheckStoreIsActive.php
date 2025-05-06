<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Store;

class CheckStoreIsActive
{
    public function handle(Request $request, Closure $next)
    {
        // جلب اسم المتجر ومعرفه من الرابط
        $storeName = $request->route('name');
        $storeId = $request->route('store_id');
    
        // الدالة التي ستُستخدم للتحقق من حالة المتجر
        $checkStoreActive = function($store) {
            // حساب الوقت المتبقي للمتجر
            $remainingTime = $store->remainingTime();
            $days = $remainingTime['days'];
            $hours = $remainingTime['hours'];
    
            // إذا انتهت الفترة الزمنية للمتجر، يتم تعطيله
            if ($days < 0 && $hours < 0) {
                $store->active = 0;
            }
    
            // إذا كان المتجر غير مفعل، يرجع رسالة خطأ
            if (!$store->active) {
                return response()->view('error.general', [
                    'statusCode' => 403,
                    'errorMessage' => 'هذا المتجر موقف مؤقتاً.'
                ]);
            }
    
            return null; // لا يوجد خطأ
        };
    
        // إذا كان اسم المتجر موجودًا في الرابط
        if ($storeName) {
            $store = Store::where('name', $storeName)->first();
            if (!$store) {
                return response()->view('error.general', [
                    'statusCode' => 404,
                    'errorMessage' => 'المتجر غير موجود.'
                ]);
            }
    
            // التحقق من حالة المتجر
            $response = $checkStoreActive($store);
            if ($response) {
                return $response;
            }
    
            // إضافة المتجر إلى الطلب
            $request->attributes->add(['store' => $store]);
        } 
        // إذا كان معرف المتجر موجودًا في الرابط
        elseif ($storeId) {
            $store = Store::find($storeId);
            if (!$store) {
                return response()->view('error.general', [
                    'statusCode' => 404,
                    'errorMessage' => 'المتجر غير موجود.'
                ]);
            }
    
            // التحقق من حالة المتجر
            $response = $checkStoreActive($store);
            if ($response) {
                return $response;
            }
    
            // إضافة المتجر إلى الطلب
            $request->attributes->add(['store' => $store]);
        }
    
        // إذا كان كل شيء على ما يرام، تابع تنفيذ الطلب
        return $next($request);
    }
    
}    
