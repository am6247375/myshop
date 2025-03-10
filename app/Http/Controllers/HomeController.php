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
        $user = Auth::user();
       
        if ($user->store) {
            return redirect()->route("dashboard.index", $user->store->id);
        }elseif ( $user->stores->first()) {
            return redirect()->route("dashboard.index", $user->stores->first()->id);
        }   
        $storeHome = session('store_home');
        if ($storeHome) {
            return  redirect()->intended($storeHome);
        $request->session()->forget('store_home');

        }
        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {  $storeHome = session('store_home'); // تحقق من وجود الصفحة الرئيسية للمتجر في السيشن
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($storeHome) {
            return  redirect()->intended($storeHome);
        }
        $request->session()->forget('store_home');
        return redirect('/'); // الصفحة الرئيسية للمنصة
    }
    
}
