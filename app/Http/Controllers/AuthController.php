<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use Auth;
class AuthController extends Controller
{
    public function getLogin()
    {
    	return view("pages.auth.login");
    }

    public function postLogin(Request $request)
    {
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required',
    	]);

    	$credentials = [
    		'username' => $request->username,
    		'password' => $request->password,
    	];

    	// dd(Auth::attempt($credentials));

    	if (Auth::attempt($credentials)) {
    		return redirect()->route("init");
    	}else{
    		return redirect()->back();
    	}
    }

    public function getRegister()
    {
    	return view("pages.auth.register");
    }

    public function postRegister(Request $request)
    {
    	$this->validate($request, [
    		'username' => 'required|unique:users|min:2',
    		'password' => 'required',
    		'name' => 'required',
    	]);

    	$user = User::create([
    		'username' => $request->username,
    		'password' => bcrypt($request->password),
    		'role' => "admin",
    	]);

    	$admin = Admin::create([
    		'name' => $request->name,
    		'user_id' => $user->id,
    	]);

    	Auth::loginUsingId($user->id);

    	return redirect()->route("admin.dashboard");

    }

    public function myLogout()
    {
    	Auth::logout();

    	return redirect('/z/login');
    }
}
