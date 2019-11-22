<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class EmployeeMiddleware
{
    function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->user()['role'] != 'employee') {
            abort(404);
        }
        return $next($request);
    }
}
