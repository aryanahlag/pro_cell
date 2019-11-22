@extends('layouts.master', ["activePage" => "dashboard", "titlePage" => "Dashboard" ])

@section('content')
    @if (!Auth::guest())
        @if (Auth::user()->role == 'admin')
            <h1>Halo Admin</h1>
        @elseif(Auth::user()->role == 'employee')
            <h1>Selamat datang Di Zena Cell</h1>
        @else
            <h1>Kamu siapa ?</h1>
        @endif
    @endif
@endsection

