<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashbaordStoreController extends Controller
{
    //

    public function index($store_id = null)
    {
        $store = Store::find($store_id);
        //  dd(Auth()->user()->store);
        return view('store_dashboard.index', compact('store'));
    }


    public function manage_admin($store_id = null)
    {
        $store = Store::find($store_id);

        $admins = StoreManagement::where('store_id', $store_id)
            ->with(['role', 'permission', 'user'])->get()->groupBy('user_id');
        return view('store_dashboard.manage_admin', compact('admins', 'store'));
    }
    public function admin_create_view($store_id)
    {
        // جلب بيانات المتجر، وإرجاع خطأ 404 إذا لم يوجد المتجر
        $store = Store::findOrFail($store_id);

        // يمكن تعديل استعلام المستخدمين ليستبعد الموظفين الموجودين بالفعل في المتجر
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('store_dashboard.admin_create', compact('store', 'users', 'roles', 'permissions'));
    }
    public function admin_create(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
            'sex' => 'required|in:male,female',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
            'store_id' => 'required|exists:stores,id'
        ]);

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
            $store_management->role_id = $request->role_id;
            $store_management->permission_id = $permission_id;
            $store_management->save();
        }
        return redirect()->back()->with('success', 'تم تحديث صلاحيات المستخدم بنجاح');
    }
    public function admin_edit_view($store_id, $admin_id)
    {
        $store = Store::findOrFail($store_id);

        // جلب بيانات المستخدم عبر `StoreManagement`
        $storeManagement = StoreManagement::where('store_id', $store_id)
        ->where('user_id', $admin_id)
        ->with(['permission','user']) // جلب فقط الصلاحيات الخاصة بهذا المتجر
        ->get();     
            // dd($storeManagement);

        $user=User::findOrFail($admin_id);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('store_dashboard.admin_update', compact('storeManagement','store', 'user', 'roles', 'permissions'));
    }

    public function admin_edit(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'phone' => 'required|string|max:15',
            'sex' => 'required|in:male,female',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array', // جعل الصلاحيات إلزامية
            'permissions.*' => 'exists:permissions,id',
            'password' => 'nullable|min:6',
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
                    'role_id' => $request->role_id,
                    'updated_at' => now(),
                ]
            );
        }
    
        return redirect()->route('admin.edit.view', [$request->store_id, $request->user_id])
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }
    public function admin_delete($store_id, $admin_id)
    {
        // حذف الإدخالات المرتبطة بالمستخدم في جدول StoreManagement
        StoreManagement::where('user_id', $admin_id)
            ->where('store_id', $store_id)
            ->delete();
    
        return redirect()->route('manage.admin', $store_id)
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

}    