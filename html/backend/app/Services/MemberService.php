<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Utils\DBU;

use App\Models\Member;
use App\Models\User;
use App\Models\UserType;

class MemberService
{
    public function createMember(Request $request)
    {
        $results = array(
            'result' => '',
            'token' => ''
        );

        $user_login_id = $request->input('user_login_id');
        $user_name = $request->input('user_name');

        // 招待管理者なし
        if (empty($user_login_id) or empty($user_name)) {
            $results['result'] = 'not_find_user';
            return $results;
        }

        $user_member = Member::with(['user'])
            ->where('login_id', '=', $user_login_id)
            ->where('status', '=', 1)
            ->first();

        // 招待管理者の情報の誤り
        if ($user_name != $user_member->user->user_name) {
            $results['result'] = 'not_find_user';
            return $results;
        }

        $login_id = $request->input('login_id');
        $another_user = Member::where('login_id', '=', $login_id)
            ->where('status', '=', 1)
            ->first();

        // login_idが使用済の場合
        if (!empty($another_user)) {
            $results['result'] = 'already_use_login_id';
            return $results;
        }

        $name = $request->input('member_name');
        $password = $request->input('password');

        try {
            DBU::beginTransaction();

            $new_member = Member::getNew();

            $new_member->name = $name;
            $new_member->login_id = $login_id;
            $new_member->password = password_hash($password, PASSWORD_DEFAULT);
            $new_member->remember_token = generateAccessToken();
            $new_member->verified_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $new_member->last_login_at = date("Y-m-d H:i:s");
            $new_member->user_member_id = $user_member->id;
            $new_member->approved_flag = 0;
            $new_member->status = 1;

            $new_member->save();
            DBU::commit();

            $results['result'] = 'OK';
            $results['token'] = $new_member->remember_token;
        }
        catch (\Exception $e) {
            DBU::rollBack();
        }

        return $results;
    }

    public function getTopProfile($auth)
    {
        $results = array(
            'result' => false,
            'name' => $auth->name,
            'user_type_id' => 0
        );

        $member_id = $auth->id;
        $user = User::where('member_id', '=', $member_id)
            ->where('status', '=', 1)
            ->first();

        if (!empty($user)) {
            $results['user_type_id'] = $user->user_type_id;
        }

        $results['result'] = true;

        return $results;
    }
}