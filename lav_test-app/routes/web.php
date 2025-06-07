<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

Route::middleware('web')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::post('/check_username', [UserController::class, 'checkUsername'])->name('check_username');

    Route::get('lang/{locale}', function ($locale) {
        if (!in_array($locale, ['en', 'ar'])) {
            abort(400);
        }

        session(['locale' => $locale]);

        return redirect('/register'); // Redirect explicitly to test
//        return back();
    });
});
