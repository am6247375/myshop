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
        $store_id = $request->route('store_id');
        $owner = Store::where(['owner_id' => $user->id, 'id' => $store_id])->first();
        $management = StoreManagement::where(['user_id' => $user->id, 'store_id' => $store_id])->first();
        if ($owner || $management) {
            return $next($request);
        }
        return abort(403, 'ليس لديك صلاحية للوصول الى هذه الصفحة');




        //         // الحصول على المستخدم المسجل حاليًا
        // $user = Auth()->user();

        // // جلب معرف المتجر من مسار الطلب
        // $store_id = $request->route('store_id');

        // // التحقق مما إذا كان المستخدم هو مالك المتجر
        // $owner = Store::where([
        //     'owner_id' => $user->id, // تطابق بين مالك المتجر والمستخدم الحالي
        //     'id' => $store_id        // تطابق معرف المتجر المطلوب
        // ])->first();

        // // التحقق مما إذا كان المستخدم ضمن إدارة المتجر
        // $management = StoreManagement::where([
        //     'user_id' => $user->id,  // تطابق بين المستخدم الحالي والمسجل في إدارة المتجر
        //     'store_id' => $store_id  // التأكد من أن المتجر هو نفس المتجر المطلوب
        // ])->first();

        // // السماح بالوصول إذا كان المستخدم مالك المتجر أو جزءًا من إدارته
        // if ($owner || $management) {
        //     return $next($request); // المتابعة إلى الطلب التالي في السلسلة (تم السماح بالوصول)
        // }

        // // إرجاع استجابة خطأ 403 إذا لم يكن المستخدم لديه الصلاحيات المطلوبة
        // return abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة');

    }
}
