<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot()
    {
        parent::boot();

        Route::middleware('web')->group(function () {
            Route::get('/dashboard', function () {
                $user = Auth::user();

                if ($user->role === 'admin') {
                    return redirect('/tickets');
                } elseif ($user->role === 'agent') {
                    return redirect('/tickets');
                } else {
                    return redirect('/tickets');
                }
            })->middleware(['auth'])->name('dashboard');
        });
    }
}
