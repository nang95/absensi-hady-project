<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        switch (auth()->user()->roles()->pluck('name')->first()) {
            case 'admin':
                return redirect()->to('/admin');
                break;
            case 'pegawai':
                return redirect()->to('/pegawai');
                break;
        }
    }
}
