<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Api\DeudasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/',[SiteController::class, 'registroContactame'])->name('index');

Route::group([
    'prefix' => 'auth'
], function () {
    
    Route::post('login',[UserController::class, 'login']);
    Route::post('signup',[UserController::class, 'signUp']);
    
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout',[UserController::class, 'logout']);
        //Route::get('user', 'Api/UserController@clients');
    });
});



Route::post('contactame',[UserController::class, 'registroContactame']); 


Route::group([
    'prefix' => 'usuarios'
], function () {
    
    Route::get('deudas/{documento}/{tipoDocumento}',[DeudasController::class, 'deudas']);
    Route::get('deudas-bcra/{documento}/{tipoDocumento}',[DeudasController::class, 'deudasBCRA']);
    Route::get('deuda/detalle/{iddeuda}',[DeudasController::class, 'deudadetalle']);
    Route::post('deuda/create/refinanciacion',[DeudasController::class, 'createRefinanciacion']);
    
});




// Route::group([
//     'prefix' => 'user'
// ], function () {
    
//     Route::post('deudas',[UserController::class, 'user']);
    
// })->middleware('client');

