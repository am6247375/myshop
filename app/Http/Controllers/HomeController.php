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

        if ($user->store || $user->stores->first()) {
            return redirect()->route('stores');
        } 
        $storeHome = session('store_home');
        if ($storeHome) {
            session()->forget('store_home');
            return  redirect()->intended($storeHome);
        }
        return redirect()->intended('/');
    }
}
