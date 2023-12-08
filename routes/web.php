<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //--------------------------
    // This code has several problems. You can show your experience by fixing them or explaining what would you do differently.
    Route::get('buy/{cookies}', function ($cookies) {
        $user = Auth::user();

        $wallet = $user->wallet;

        if($wallet < $cookies) {
            return "You do not have enough amount to but cookies. Your current wallet balance is $wallet";
        }
        $user->update(['wallet' => $wallet - $cookies * 1]);

        Log::info('User ' . $user->email . ' have bought ' . $cookies . ' cookies'); // we need to log who ordered and how much
        return 'Success, you have bought ' . $cookies . ' cookies!';
    })->where('cookies', '[0-9]+');

});

require __DIR__.'/auth.php';
