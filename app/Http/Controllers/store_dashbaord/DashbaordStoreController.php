<?php

namespace App\Http\Controllers\store_dashbaord;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Permission;
use App\Models\product;
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
    
        // مثال لجلب بيانات الرسم البياني (يمكنك تعديل الاستعلامات حسب متطلباتك)
        $chartLabels = ['اليوم 1', 'اليوم 2', 'اليوم 3', 'اليوم 4', 'اليوم 5'];
        $chartData = [120, 200, 150, 300, 250];
    
        // الحصول على المنتجات الأكثر مبيعًا
        $topSellingProducts = product::orderBy('created_at', 'desc')
            ->take(4)
            ->get();
    
        return view('store_dashboard.index', compact('store', 'chartLabels', 'chartData', 'topSellingProducts'));
    }
    
    public function orders_manage($store_id = null)
    {
        $store = Store::find($store_id);
        
       $orders=Order::where('store_id',$store_id)->get();
        return view('store_dashboard.orders_manage', compact('orders', 'store'));
    }

}