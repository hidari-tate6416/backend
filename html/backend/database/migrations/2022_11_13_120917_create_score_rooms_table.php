<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_db.score_rooms', function (Blueprint $table) {
            $table->id()->comment('スコアルームID');
            $table->string('room_name')->nullable()->comment('ルーム名');
            $table->string('room_password')->nullable()->comment('ルームパスワード');
            $table->Integer('default_score')->default(0)->comment('デフォルトスコア');
            $table->dateTime('expired_at')->nullable()->comment('ルーム使用期限');
            $table->Integer('host_member_id')->nullable()->comment('ルームホスト会員ID');
            $table->Integer('host_member_score')->default(0)->comment('ルームホストスコア');
            $table->Integer('host_member_color_id')->default(0)->comment('ルームホストカラーID');
            $table->Integer('guest1_member_id')->nullable()->comment('ゲスト1会員ID');
            $table->Integer('guest1_member_score')->default(0)->comment('ゲスト1スコア');
            $table->Integer('guest1_member_color_id')->default(0)->comment('ゲスト1カラーID');
            $table->Integer('guest2_member_id')->nullable()->comment('ゲスト2会員ID');
            $table->Integer('guest2_member_score')->default(0)->comment('ゲスト2スコア');
            $table->Integer('guest2_member_color_id')->default(0)->comment('ゲスト2カラーID');
            $table->Integer('guest3_member_id')->nullable()->comment('ゲスト3会員ID');
            $table->Integer('guest3_member_score')->default(0)->comment('ゲスト3スコア');
            $table->Integer('guest3_member_color_id')->default(0)->comment('ゲスト3カラーID');
            $table->Integer('guest4_member_id')->nullable()->comment('ゲスト4会員ID');
            $table->Integer('guest4_member_score')->default(0)->comment('ゲスト4スコア');
            $table->Integer('guest4_member_color_id')->default(0)->comment('ゲスト4カラーID');
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
        Schema::dropIfExists('app_db.score_rooms');
    }
}
