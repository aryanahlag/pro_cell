<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function init()
    {
        if (Auth::guest()) {
            return redirect()->route("getLogin");
        } else {
            if (Auth::user()->role = "admin") {
                return redirect()->route("admin.dashboard");
            }else if (Auth::user()->role = "employee") {
                return redirect()->route("employee.dashboard");
            } else {
                return redirect()->route("getLogin");
            }
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
