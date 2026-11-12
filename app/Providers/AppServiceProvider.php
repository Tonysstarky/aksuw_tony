<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Glassmorphism görnüşli sahypalamak (Tailwind gerek däl)
        Paginator::defaultView('vendor.pagination.glass');
        Paginator::defaultSimpleView('vendor.pagination.glass');
    }
}
