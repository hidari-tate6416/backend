<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insider_db.templetes', function (Blueprint $table) {
            $table->id()->comment('テンプレートID');
            $table->integer('member_id')->comment('会員ID');
            $table->string('templete_name')->comment('テンプレート名');
            $table->smallInteger('use_base_word')->default(0)->comment('基本ワード使用可否');
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
        Schema::dropIfExists('insider_db.templetes');
    }
}
