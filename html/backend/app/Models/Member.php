<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Utils\DBU;

class Member extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'app_db.' . 'members';
    protected $guarded = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class)->where('status', '=', 1);
    }

    public function templetes()
    {
        return $this->hasMany(\App\Models\Insider::class)->where('status', '=', 1);
    }

    static function login(Request $request)
    {
        $results = array(
            'token' => '',
            'user_type' => 0,
        );

        $login_id = $request->input('login_id');
        $password = $request->input('password');

        $member = Member::with(['user'])
            ->where('status', '=', 1)
            ->where('approved_flag', '=', 1)
            ->where('login_id', '=', $login_id)
            ->first();

        if (empty($member) or !password_verify($password, $member->password)) {
            return $results;
        }

        try {
            DBU::beginTransaction();

            $member->remember_token = generateAccessToken();
            $member->verified_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $member->last_login_at = date("Y-m-d H:i:s");

            $member->save();
            DBU::commit();

        }
        catch (\Exception $e) {
            DBU::rollBack();
            return $results;
        }

        $results['token'] = $member->remember_token;

        // 管理者タイプ
        if (!empty($member->user)) {
            $results['user_type'] = $member->user->user_type;
        }

        return $results;
    }

    static function logout(Request $request)
    {
        $result = false;

        $token = $request->bearerToken();

        $member = Member::where('status', '=', 1)
            ->where('approved_flag', '=', 1)
            ->where('remember_token', '=', $token)
            ->first();

        if (empty($member)) {
            return $result;
        }

        try {
            DBU::beginTransaction();

            $member->remember_token = '';
            $member->verified_at = null;

            $member->save();

            DBU::commit();
            $result = true;

        }
        catch (\Exception $e) {
            // echo $e;
            DBU::rollBack();
            return $result;
        }

        return $result;

    }

    static function auth($token)
    {
        $member = Member::where('status', '=', 1)
            ->where('approved_flag', '=', 1)
            ->where('remember_token', '=', $token)
            ->first();

        if (empty($member)) {
            return $member;
        }

        try {
            DBU::beginTransaction();

            $member->verified_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $member->last_login_at = date("Y-m-d H:i:s");

            $member->save();

            DBU::commit();

        }
        catch (\Exception $e) {
            // echo $e;
            DBU::rollBack();
            $member = array();
        }

        return $member;
    }

    static function userAuth($token, $min_user_type = 4)
    {
        $member = Member::with(['user'])
            ->where('status', '=', 1)
            ->where('approved_flag', '=', 1)
            ->where('remember_token', '=', $token)
            ->first();

        if (empty($member->user) or $min_user_type <= $member->user->user_type_id) {
            $member = array();
            return $member;
        }

        try {
            DBU::beginTransaction();

            $member->verified_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
            $member->last_login_at = date("Y-m-d H:i:s");

            $member->save();

            DBU::commit();

        }
        catch (\Exception $e) {
            // echo $e;
            DBU::rollBack();
            $member = array();
        }

        return $member;
    }
}
