<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\InsiderController;
use App\Http\Controllers\API\ItoController;

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

Route::prefix('app')->group(function () {

    // 会員登録APi
    Route::post('/create_member', [MemberController::class, 'create_member']);

    // ログインAPi
    Route::post('/login', [MemberController::class, 'login']);

     // ログアウトAPi
     Route::get('/logout', [MemberController::class, 'logout']);
});


Route::prefix('insider')->group(function () {

    // 初期API
    Route::post('/ini', [InsiderController::class, 'ini']);
});


Route::prefix('ito')->group(function () {

    // 初期API
    Route::post('/ini', [ItoController::class, 'ini']);
});