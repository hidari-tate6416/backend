<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Member;

class MenuController extends Controller
{
    // スコアルーム作成画面項目API
    public function create_score_room(Request $request) {

        $auth = Member::auth($request->bearerToken());
        if (empty($auth)) {
            return response()->unauthorized();
        }

        try {
            $service = app()->make('MenuService');
            $ret = $service->createScoreRoom();
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $ret_str = (!empty($ret)) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "menus" => $ret
        );

        return response()->success($result);
    }
}
