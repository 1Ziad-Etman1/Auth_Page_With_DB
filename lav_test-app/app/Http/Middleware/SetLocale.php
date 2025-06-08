<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));

        // Force reload translations
        app()->setLocale($locale);
        $translator = app('translator');
        $translator->setLocale($locale);
        $translator->reload();

        // Set direction
        config(['app.direction' => $locale === 'ar' ? 'rtl' : 'ltr']);

        return $next($request);
    }
}

