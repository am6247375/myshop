<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Store;
use App\Models\StoreManagement;
use App\Models\User;
use Illuminate\Http\Request;

class DashbaordStoreController extends Controller
{
    //
   
    public function index($store_id=null)
    {
        $store=Store::find($store_id);
//  dd(Auth()->user()->store);
        return view('store_dashboard.index', compact('store'));
    }
    

    public function manage_admin($store_id=null)
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
        $permissions =Permission::all();

        return view('store_dashboard.admin_create', compact('store', 'users', 'roles', 'permissions'));
    }

}
