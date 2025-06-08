<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon; // Add this import

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Set Carbon locale
        Carbon::setLocale(config('app.locale'));

        // For Arabic specifically
        if (config('app.locale') === 'ar') {
            setlocale(LC_TIME, 'ar_SA.utf8');
            \DB::statement('SET lc_time_names = "ar_SA"'); // For Arabic MySQL dates
        }
    }
}
