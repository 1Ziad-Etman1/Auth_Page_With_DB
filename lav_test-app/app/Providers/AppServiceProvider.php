<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Set Carbon locale based on current application locale
        $locale = Session::get('locale', config('app.locale'));
        // Carbon::setLocale($locale);

        // Handle Arabic-specific settings
        if ($locale === 'ar') {
            // Set RTL direction for Arabic
            Session::put('direction', 'rtl');
        } else {
            // Set LTR direction for other languages
            Session::put('direction', 'ltr');
        }

        // Set application locale
        App::setLocale($locale);
    }
}
