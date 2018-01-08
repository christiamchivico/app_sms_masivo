<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabResultadoMailingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_resultado_mailing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entregado');
            $table->integer('rechazado');
            $table->integer('rebotado');
            $table->dateTime('fecha_entrega');
            $table->dateTime('fecha_leido');
            $table->integer('rel_campana_publico_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('rel_campana_publico_id')->references('id')->on('rel_campana_publico');
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
        Schema::dropIfExists('tab_resultado_mailing');
    }
}
