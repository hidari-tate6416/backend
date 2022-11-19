<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\AppService;
use App\Models\Member;

class AppController extends Controller
{
    // スコアルーム作成API
    public function create_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->createScoreRoom($request, $user_auth->id);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret['result'])) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "score_room_id" => $ret['score_room_id']
        );

        return response()->success($result);
    }

    // スコアルーム一覧API
    public function list_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->listScoreRoom();
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret['result'])) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "rooms" => $ret['rooms']
        );

        return response()->success($result);
    }

    // スコアルーム情報取得API
    public function get_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->getScoreRoom($request);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret['result'])) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "room" => $ret['room']
        );

        return response()->success($result);
    }

    // スコアルーム参加API
    public function join_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->joinScoreRoom($request, $user_auth->id);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret)) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str
        );

        return response()->success($result);
    }

    // スコアルーム情報取得API
    public function get_detail_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->getDetailScoreRoom($request);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret)) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "score_room" => $ret
        );

        return response()->success($result);
    }


    // スコアルームリセットAPI
    public function reset_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->resetScoreRoom();
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret['result'])) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "empty_room_count" => $ret['empty_room']
        );

        return response()->success($result);
    }

    // スコアルームログアウトAPI
    public function logout_score_room(Request $request) {

        $user_auth = Member::userAuth($request->bearerToken());
        if (empty($user_auth)) {
            return response()->unauthorized();
        }
        
        try {
            $service = app()->make('AppService');
            $ret = $service->logoutScoreRoom($request, $user_auth->id);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret)) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str
        );

        return response()->success($result);
    }
}
