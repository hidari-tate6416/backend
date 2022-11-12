<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_db.user_types', function (Blueprint $table) {
            $table->id()->comment('管理者タイプID');
            $table->string('type_name')->comment('管理者タイプ名');
            $table->tinyInteger('status')->default(1)->comment('ステータス');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_db.user_types');
    }
}
