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
            echo $e;
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

        $ret_str = (!empty($ret)) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str
        );

        return response()->success($result);
    }
}
