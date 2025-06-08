<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400, 'Invalid locale');
        }

        // Store in session
        session(['locale' => $locale]);

        // Set immediately for current request
//        app()->setLocale($locale);
        App::setLocale($locale);
        session()->save();
        return redirect()->back();
    }
}
