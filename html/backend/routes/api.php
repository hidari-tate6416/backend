<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\AppController;
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

    // 会員登録API
    Route::post('/create_member', [MemberController::class, 'create_member']);

    // ログインAPI
    Route::post('/login', [MemberController::class, 'login']);

    // ログアウトAPI
    Route::get('/logout', [MemberController::class, 'logout']);

    // マイページトップ会員情報取得API
    Route::get('/get_top_profile', [MemberController::class, 'get_top_profile']);

    // スコアルーム作成API
    Route::post('/create_score_room', [AppController::class, 'create_score_room']);

    // スコアルーム一覧API
    Route::get('/list_score_room', [AppController::class, 'list_score_room']);

    // スコアルーム情報取得API
    Route::get('/get_score_room', [AppController::class, 'get_score_room']);

    // スコアルーム参加API
    Route::post('/join_score_room', [AppController::class, 'join_score_room']);

    // スコアルーム詳細取得API
    Route::post('/get_detail_score_room', [AppController::class, 'get_detail_score_room']);

    // スコアルームリセットAPI
    Route::get('/reset_score_room', [AppController::class, 'reset_score_room']);

    // スコアルームログアウトAPI
    Route::get('/logout_score_room', [AppController::class, 'logout_score_room']);

    // スコアルームゲストログアウトAPI
    Route::post('/logout_guest_score_room', [AppController::class, 'logout_guest_score_room']);
});


Route::prefix('insider')->group(function () {

    // 初期API
    Route::get('/ini', [InsiderController::class, 'ini']);
});


Route::prefix('ito')->group(function () {

    // 初期API
    Route::get('/ini', [ItoController::class, 'ini']);
});