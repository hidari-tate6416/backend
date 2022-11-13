<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItoSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ito_db.subjects', function (Blueprint $table) {
            $table->id()->comment('お題ID');
            $table->integer('templete_id')->default(0)->comment('テンプレートID');
            $table->string('subject_word')->comment('お題ワード');
            $table->string('min_word')->comment('お題最小ワード');
            $table->string('max_word')->comment('お題最大ワード');
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
        Schema::dropIfExists('ito_db.subjects');
    }
}
