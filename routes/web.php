<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;

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

//Route::get('/', 'App\Http\Controllers\Site\SiteController@index');
Route::get('/',[SiteController::class, 'index'])->name('index');
Route::post('login',[SiteController::class, 'login']);


Route::group([
    'middleware' => 'auth'
], function() {
    Route::get('panel',[SiteController::class, 'panel'])->name('panel');
    Route::post('user/new',[SiteController::class, 'new'])->name('user.new');
    Route::post('user/edit',[SiteController::class, 'edit'])->name('user.edit');
    Route::get('logout',[SiteController::class, 'logout']);
});

// Route::get('/', 'Site\SiteController@index');
