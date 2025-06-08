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

        // Store in session and save immediately
        session(['locale' => $locale]);
        session()->save();

        // Set for current request
        App::setLocale($locale);  // Correct way to set locale

        // Important: Clear translation cache
        $translator = app('translator');
        $translator->setLocale($locale);

        return redirect()->back();
    }
}
