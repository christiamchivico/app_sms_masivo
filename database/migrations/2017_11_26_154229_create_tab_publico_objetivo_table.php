<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabPublicoObjetivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_publico_objetivo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('nombre');
            $table->string('telefono');
            $table->integer('tab_publico_inf_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_publico_inf_id')->references('id')->on('tab_publico_inf');
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
        Schema::dropIfExists('tab_publico_objetivo');
    }
}
