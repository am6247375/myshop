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
            $user = Auth::user();

            if ($user->store || $user->stores->first()) {
                return redirect()->route('stores');
            }
            $storeHome = session('store_home');
            $subscribe = session('subscribe');
            $welcome = session('welcome');
           
            if ($storeHome  ) {
                session()->forget('store_home');
                return redirect()->intended($storeHome);
            } elseif ($subscribe) {
                session()->forget('subscribe');
            //   dd(redirect()->intended($subscribe));  
                return redirect()->intended($subscribe);
            }
            session()->forget('welcome');
             // إعادة التوجيه إلى الصفحة الرئيسية إذا لم يوجد شيء في الجلسة
            return redirect()->intended($welcome);
    
        } catch (\Exception $e) {
            // تسجيل الخطأ في سجل النظام للمراجعة
            // \Log::error('Error in HomeController@index: ' . $e->getMessage());
    
            // إعادة التوجيه مع رسالة خطأ
            return redirect()->intended('/') ->withErrors('حدث خطأ، يرجى المحاولة لاحقًا.');
        }
    }
    
}
