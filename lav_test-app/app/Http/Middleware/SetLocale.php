<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // 1. Try from session
        if ($locale = session('locale')) {
            $this->setLocale($locale);
        }
        // 2. Fallback to config
        else {
            $this->setLocale(config('app.locale'));
        }

        return $next($request);
    }

    private function setLocale($locale)
    {
        App::setLocale($locale);
        Carbon::setLocale($locale);
        app('translator')->setLocale($locale);

        // Set direction
        config(['app.direction' => $locale === 'ar' ? 'rtl' : 'ltr']);
    }
}

