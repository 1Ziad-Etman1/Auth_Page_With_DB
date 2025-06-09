<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, Config::get('app.available_locales'))) {
            // Force set the locale in multiple ways
            Session::put('locale', $locale);
            App::setLocale($locale);

            // Set direction based on locale
            $direction = $locale === 'ar' ? 'rtl' : 'ltr';
            Session::put('direction', $direction);

            // Clear all caches

            // Log the change
            Log::info('Language switched', [
                'locale' => $locale,
                'direction' => $direction,
                'app_locale' => App::getLocale(),
                'session_locale' => Session::get('locale'),
                'config_locale' => Config::get('app.locale')
            ]);
        }

        // Force a fresh page load instead of back()
        return redirect()->to(url()->previous());
    }
}
