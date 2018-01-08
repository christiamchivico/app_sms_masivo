<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabPublicoInfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_publico_inf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('cat_segmentacion_publico_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('cat_segmentacion_publico_id')->references('id')->on('cat_segmentacion_publico');
            $table->integer('tab_empresa_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_empresa_id')->references('id')->on('tab_empresa');
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
        Schema::dropIfExists('tab_publico_inf');
    }
}
