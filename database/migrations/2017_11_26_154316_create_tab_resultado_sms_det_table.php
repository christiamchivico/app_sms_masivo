<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabResultadoSmsDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_resultado_sms_det', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tab_resultado_sms_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_resultado_sms_id')->references('id')->on('tab_resultado_sms');
            $table->integer('tab_campana_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_campana_id')->references('id')->on('tab_campana');
            $table->integer('tab_publico_obejtivo_info_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_publico_obejtivo_info_id')->references('id')->on('tab_publico_objetivo');
            $table->integer('aceptado');
            $table->dateTime('fecha_envio');
            $table->integer('enviado');
            $table->dateTime('fecha_confirmado');
            $table->string('resultado_t');
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
        Schema::dropIfExists('tab_resultado_sms_det');
    }
}
