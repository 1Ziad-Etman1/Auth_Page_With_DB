<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LanguageController;



Route::middleware('web')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::post('/check_username', [UserController::class, 'checkUsername'])->name('check_username');

    Route::get('language/{locale}', [LanguageController::class, 'switch'])
        ->name('lang.switch');
    Route::get('/test-lang', function() {
        return [
            'current_locale' => app()->getLocale(),
            'session_locale' => session('locale'),
            'translation' => trans('messages.full_name'),
            'all_messages' => trans('messages') // Show all translations
        ];
    });
    Route::get('/test-config', function() {
        return [
            'locale' => config('app.locale'),
            'fallback' => config('app.fallback_locale'),
            'available' => config('app.available_locales', ['en']),
            'timezone' => config('app.timezone'),
        ];
    });
});
