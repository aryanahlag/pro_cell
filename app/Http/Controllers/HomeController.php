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
        // dd(Auth::user()->role == "employee");
        // dd("aksajs");
        if (Auth::guest()) {
            return redirect()->route("getLogin");
        } else {
            if (Auth::user()->role == "admin") {
                return redirect()->route("admin.dashboard");
            }
            if (Auth::user()->role == "employee") {
                return redirect()->route("employee.dashboard");
            }
            return redirect()->route("getLogin");
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
