<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            // استرجاع المستخدم الحالي
            $user = Auth::user();
    
            // التحقق مما إذا كان للمستخدم متجر مرتبط
            if ($user->store || $user->stores->first()) {
                return redirect()->route('stores');
            }
    
            // التحقق من وجود روابط مخزنة في الجلسة لإعادة التوجيه بعد تسجيل الدخول
            $storeHome = session('store_home');
            $subscribe = session('subscribe');
            $welcome = session('welcome');
    // dd($storeHome, $subscribe);
            if ($storeHome  ) {
                session()->forget('store_home');
                return redirect()->intended($storeHome);
            } elseif ($subscribe) {
                session()->forget('subscribe');
                return redirect()->intended($subscribe);
            }
            session()->forget('welcome');
            // إعادة التوجيه إلى الصفحة الرئيسية إذا لم يوجد شيء في الجلسة
            return redirect()->intended($welcome);
    
        } catch (\Exception $e) {
            // تسجيل الخطأ في سجل النظام للمراجعة
            // \Log::error('Error in HomeController@index: ' . $e->getMessage());
    
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->route('home')->withErrors('حدث خطأ، يرجى المحاولة لاحقًا.');
        }
    }
    
}
