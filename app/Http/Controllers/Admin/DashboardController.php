<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\User;
use App\Admin;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::count();
        $products = Product::count();
        $users = User::count();
        $admin = Admin::count();

        return view('admin.dashboard',compact(['categories','products','users','admin']));
    }

     public function dologin($id)
    {
        session(['admin_login' => Auth::guard('admin')->user()->id]);
        Auth::loginUsingId($id);
        return redirect('dashboard');
    }

    public function dologinasAdmin($id)
    {
        session(['admin_login' => Auth::guard('admin')->user()->id]);
        Auth::guard('admin')->loginUsingId($id);
        return redirect('/admin/dashboard');
    }

}
