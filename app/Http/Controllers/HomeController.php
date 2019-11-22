<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;
use File;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function init()
    {
        if (Auth::guest()) {
            return redirect()->route('home');
        } else {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('employee.dashboard');
            }
        }
    }

    public function file($url)
    {
        $url = str_replace('-', '/', $url);
        $path = storage_path('app/' . $url);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    }
}
