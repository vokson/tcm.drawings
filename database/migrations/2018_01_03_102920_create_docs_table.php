<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trans_id')->unsigned();
            $table->string('nipigaz_code');
            $table->string('tcm_code');
            $table->string('revision');
            $table->integer('class');
            $table->string('reason');
            $table->string('english_title');
            $table->string('russian_title');
            $table->string('pdf_file')->nullable();
            $table->string('native_file')->nullable();
            $table->timestamps();
        });

        // FOREIGN KEYS В SQLITE НЕ РАБОТАЕТ ИЗ LARAVEL БЕЗ ТАНЦЕВ С БУБНАМИ, НО ОСТАВИЛ КАК ЕСТЬ
        Schema::table('docs', function (Blueprint $table) {
            $table->foreign('trans_id')->references('id')->on('transmittals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docs');
    }
}
