<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransmittalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transmittals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('summary');
            $table->string('name');
            $table->string('purpose');
            $table->date('issued_at');
            $table->date('reply_by')->nullable();
            $table->integer('count')->unsigned();
            
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
        Schema::dropIfExists('transmittals');
    }
}
