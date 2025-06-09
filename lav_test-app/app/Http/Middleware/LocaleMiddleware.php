<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('LocaleMiddleware started', [
            'request_path' => $request->path(),
            'request_method' => $request->method()
        ]);

        // Get locale from session or use default from config
        $locale = Session::get('locale');
        Log::info('Initial locale check', ['locale' => $locale]);
        
        // If no session locale, try to get from request or config
        if (!$locale) {
            $locale = $request->get('locale', Config::get('app.locale'));
            Log::info('Locale from request/config', ['locale' => $locale]);
        }
        
        // Ensure the locale is supported
        if (!in_array($locale, Config::get('app.available_locales'))) {
            $locale = Config::get('app.fallback_locale');
            Log::info('Using fallback locale', ['locale' => $locale]);
        }
        
        // Force set the locale in multiple ways
        Session::put('locale', $locale);
        App::setLocale($locale);
        
        // Set direction based on locale
        $direction = $locale === 'ar' ? 'rtl' : 'ltr';
        Session::put('direction', $direction);
        
        // Log final state
        Log::info('LocaleMiddleware completed', [
            'request_locale' => $locale,
            'app_locale' => App::getLocale(),
            'session_locale' => Session::get('locale'),
            'config_locale' => Config::get('app.locale'),
            'direction' => $direction,
            'available_locales' => Config::get('app.available_locales')
        ]);
        
        return $next($request);
    }
}
