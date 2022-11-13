<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_db.users', function (Blueprint $table) {
            $table->id()->comment('管理者ID');
            $table->bigInteger('member_id')->comment('会員ID');
            $table->integer('user_type_id')->comment('管理者タイプ');
            $table->string('user_name')->comment('管理者氏名');
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
        Schema::dropIfExists('app_db.users');
    }
}
