<?php
namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAdminCreate;
use App\Http\Requests\RequestAdminEdit;
use App\Models\Permission;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    public function manage_admin($store_id = null)
    {
        try {
            $store = Store::find($store_id);

            $admins = StoreManagement::where('store_id', $store_id)
                ->with(['permission', 'user'])->get()->groupBy('user_id');
            return view('store_dashboard.manage_admin', compact('admins', 'store'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    public function admin_create_view($store_id)
    {
        try {
            // جلب بيانات المتجر، وإرجاع خطأ 404 إذا لم يوجد المتجر
            $store = Store::findOrFail($store_id);

            // يمكن تعديل استعلام المستخدمين ليستبعد الموظفين الموجودين بالفعل في المتجر
            $users = User::all();

            $permissions = Permission::all();

            return view('store_dashboard.admin_create', compact('store', 'users', 'permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        } 
    }

    public function admin_create(RequestAdminCreate $request)
    {
        try {
            // التحقق من وجود المستخدم بالبريد الإلكتروني
            $user = User::where('email', $request->email)->first();

            // إذا لم يكن المستخدم موجودًا، نقوم بإنشائه
            if (!$user) {
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->phone = $request->phone;
                $user->sex = $request->sex;
                $user->save();
            }

            // حذف أي صلاحيات سابقة للمستخدم في هذا المتجر (إذا كانت موجودة)
            StoreManagement::where('user_id', $user->id)
                ->where('store_id', $request->store_id)
                ->delete();

            // إضافة الأدوار والصلاحيات الجديدة
            foreach ($request->permissions as $permission_id) {
                $store_management = new StoreManagement();
                $store_management->user_id = $user->id;
                $store_management->store_id = $request->store_id;
                $store_management->permission_id = $permission_id;
                $store_management->save();
            }

            return redirect()->back()->with('success', 'تم تحديث صلاحيات المستخدم بنجاح');
        } catch (\Exception $e) {
            // التعامل مع الأخطاء هنا
            return redirect()->back()->with('error', 'حدث خطأ أثناء تنفيذ العملية: ' . $e->getMessage());
        }
    }

    public function admin_edit_view($store_id, $admin_id)
    {
        try {
            $store = Store::findOrFail($store_id);

            // جلب بيانات المستخدم عبر `StoreManagement`
            $storeManagement = StoreManagement::where('store_id', $store_id)
                ->where('user_id', $admin_id)
                ->with(['permission', 'user']) // جلب فقط الصلاحيات الخاصة بهذا المتجر
                ->get();

            $user = User::findOrFail($admin_id);

            $permissions = Permission::all();

            return view('store_dashboard.admin_update', compact('storeManagement', 'store', 'user', 'permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء جلب البيانات: ' . $e->getMessage());
        }
    }

    public function admin_edit(RequestAdminEdit $request)
    {
        try {
            $request->validate([
                // يمكن إضافة أي عمليات تحقق إضافية هنا
            ]);

            $user = User::findOrFail($request->user_id);

            // تحديث بيانات المستخدم
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'sex' => $request->sex,
            ]);

            // تحديث كلمة المرور فقط إذا أدخل المستخدم واحدة جديدة
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            // حذف الإدخالات السابقة للمستخدم في المتجر المحدد
            StoreManagement::where('user_id', $user->id)
                ->where('store_id', $request->store_id)
                ->delete();

            // إدراج أو تحديث الصلاحيات في جدول StoreManagement
            foreach ($request->permissions as $permission_id) {
                StoreManagement::updateOrInsert(
                    [
                        'user_id' => $user->id,
                        'store_id' => $request->store_id,
                        'permission_id' => $permission_id,
                    ],
                    [
                        'updated_at' => now(),
                    ]
                );
            }

            return redirect()->route('admin.edit.view', [$request->store_id, $request->user_id])
                ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تنفيذ العملية: ' . $e->getMessage());
        }
    }

    public function admin_delete($store_id, $admin_id)
    {
        try {
            // حذف الإدخالات المرتبطة بالمستخدم في جدول StoreManagement
            StoreManagement::where('user_id', $admin_id)
                ->where('store_id', $store_id)
                ->delete();

            return redirect()->route('manage.admin', $store_id)
                ->with('success', 'تم حذف المستخدم بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف المستخدم: ' . $e->getMessage());
        }
    }
}
