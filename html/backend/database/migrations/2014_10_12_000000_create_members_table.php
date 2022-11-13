<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_db.members', function (Blueprint $table) {
            $table->id()->comment('会員ID');
            $table->string('name')->comment('会員名');
            $table->string('login_id')->comment('ログインID');
            $table->timestamp('verified_at')->nullable()->comment('トークン期限');
            $table->string('password')->comment('パスワード');
            $table->rememberToken()->nullable()->comment('トークン');
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時');
            $table->bigInteger('user_member_id')->nullable()->comment('招待管理者会員ID');
            $table->tinyInteger('approved_flag')->default(0)->comment('承認フラグ');
            $table->tinyInteger('status')->default(1)->comment('ステータス');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_db.members');
    }
}
