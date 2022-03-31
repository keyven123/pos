<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Route::view('/license', 'pages.license.license');
Route::get('/license', [LicenseController::class, 'index']);
Route::post('/license', [LicenseController::class, 'store']);
Route::view('/queue', 'pages.queue.queue')->middleware('auth');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

Route::get('/{any_path?}', [Controller::class, 'default'])->where('any_path', '(.*)');
