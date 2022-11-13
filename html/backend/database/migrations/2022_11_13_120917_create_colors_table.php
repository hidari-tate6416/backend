<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_db.colors', function (Blueprint $table) {
            $table->id()->comment('カラーID');
            $table->string('code')->nullable()->comment('カラーコード');
            $table->string('name_en')->comment('カラー名(英)');
            $table->string('name_ja')->comment('カラー名(日)');
            $table->string('text_color_name_en')->default('black')->comment('文字色(英)');
            $table->string('text_color_name_ja')->default('黒')->comment('文字色(日)');
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
        Schema::dropIfExists('app_db.colors');
    }
}
