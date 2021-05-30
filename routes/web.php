<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
    // return view('welcome');
});

Route::view('/queue', 'pages.queue.queue');
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

Route::get('/{any_path?}', [HomeController::class, 'index'])->where('any_path', '(.*)');

