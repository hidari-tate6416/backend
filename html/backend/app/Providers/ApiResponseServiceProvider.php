<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class ApiResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($data = []) {
            return response()->json(
                $data, 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('unauthorized', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 401,
                    'error_message' => '無効なトークンです',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('loginError', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 402,
                    'error_message' => 'ログインできませんでした',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('invalidURL', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 403,
                    'error_message' => '無効なURLが指定されました',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('expiredURL', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 404,
                    'error_message' => '指定のURLは有効期限が切れています',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('passwordError', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 405,
                    'error_message' => 'パスワードが未入力または確認パスワードと一致しません',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('invalidEmail', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 406,
                    'error_message' => 'メールアドレスが違います',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('unauthorizedAdmin', function () {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 407,
                    'error_message' => '管理者権限がありません',
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('error', function ($msg = '') {
            return response()->json([
                    'result' => "NG",
                    'error_code' => 500,
                    'error_message' => $msg,
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('error51x', function ($error_code, $company_id, $added_info = '') {
            switch ($error_code) {
            case 1: $error_message = '不正なトークンが指定されました';
                break;
            case 2: $error_message = '不正なユーザーです';
                break;
            default: $error_message = '';
                break;
            }

            $logmsg = sprintf('[%03d] %s ( %s, %s )', 510 + $error_code, $error_message, $company_id, $added_info);
            Log::channel('documents')->info($logmsg);

            return response()->json([
                    'result' => "NG",
                    'error_code' => 510 + $error_code,
                    'error_message' => $error_message,
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });

        Response::macro('error52x', function ($error_code, $document_id, $added_info = '') {
            switch ($error_code) {
            case 1: $error_message = '不正なトークンが指定されました';
                break;
            case 2: $error_message = '不正なユーザーです';
                break;
            default: $error_message = '';
                break;
            }

            $logmsg = sprintf('[%03d] %s ( %s, %s )', 520 + $error_code, $error_message, $document_id, $added_info);
            Log::channel('documents')->info($logmsg);

            return response()->json([
                    'result' => "NG",
                    'error_code' => 520 + $error_code,
                    'error_message' => $error_message,
                ], 200, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept',
                    'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
                    'Access-Control-Allow-Credentials' => true,
                ]
            );
        });
    }
}
