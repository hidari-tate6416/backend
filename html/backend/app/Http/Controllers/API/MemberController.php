<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\AppService;
use App\Services\MemberService;
use App\Models\Member;

class MemberController extends Controller
{
    // 会員登録API
    public function create_member(Request $request) {
        
        try {
            $service = app()->make('MemberService');
            $ret = $service->createMember($request);
        }
        catch (\Exception $e) {
            // echo $e;
        }

        $result = array(
            "result" => $ret['result'] ?? 'NG',
            "token" => $ret['token']
        );

        return response()->success($result);
    }


    // ログインAPI
    public function login(Request $request) {
        
        try {
            $ret = Member::login($request);
        }
        catch (\Exception $e) {
            echo $e;
        }

        $ret_str = !empty($ret['token']) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str,
            "token" => $ret['token'],
            "user_type" => $ret['user_type']
        );

        return response()->success($result);
    }

    // ログアウトAPI
    public function logout(Request $request) {
        
        try {
            $ret = Member::logout($request);
        }
        catch (\Exception $e) {
            echo $e;
        }

        $ret_str = !empty($ret) ? 'OK' : 'NG';

        $result = array(
            "result" => $ret_str
        );

        return response()->success($result);
    }
}
