<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource("pokemons", 'App\Http\Controllers\PokemonController');
    Route::apiResource('users', 'App\Http\Controllers\UserController');
    Route::apiResource("games", 'App\Http\Controllers\GameController');
    Route::apiResource("gamesOffline", 'App\Http\Controllers\OfflineController');
});
*/



 //UPDATE PRICE_POKEMONS
Route::get('user/pricePoke', [App\Http\Controllers\UserController::class,'pricePoke']);
Route::resource('pokemon', App\Http\Controllers\api\PokemonController::class)->only(['index','show','store'])->middleware('auth:sanctum');
Route::resource('getDeck', App\Http\Controllers\UserController::class)->only(['getDeck']);


Route::post('user/restarPrice', [App\Http\Controllers\UserController::class,'restar_price']);
Route::post('user/sumarPrice', [App\Http\Controllers\UserController::class,'sumar_price']);
Route::post('user/savePoke', [App\Http\Controllers\UserController::class,'save_poke']);
Route::get('pokesUser',[App\Http\Controllers\UserController::class, 'pokesUser'])->name('pokesUser');

Route::post('cart/addpoke',[App\Http\Controllers\api\CartController::class, 'addPoke'])->name('addPoke');
Route::post('cart/delpoke',[App\Http\Controllers\api\CartController::class, 'delPoke'])->name('delPoke');
Route::get('cart/getCart',[App\Http\Controllers\api\CartController::class, 'getCart'])->name('getCart');
Route::post('setRewards',[App\Http\Controllers\UserController::class, 'setRewards'])->name('setRewards');

Route::post('setPokemon/{id}',[App\Http\Controllers\UserController::class, 'setPokemon'])->name('setPokemon');
Route::post('/reset/{token}', [App\Http\Controllers\ForgotController::class, 'reset'])->name('reset');

Route::post('forgot', [App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');
Route::post('register', [App\Http\Controllers\api\RegisterController::class,'store']);

Route::get('getAvatar',[App\Http\Controllers\api\AvatarController::class,'get']);
Route::post('updateAvatar',[App\Http\Controllers\api\AvatarController::class,'update']);
