<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabResultadoSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_resultado_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tab_campana_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_campana_id')->references('id')->on('tab_campana');
            $table->integer('tab_publico_objetivo_info_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_publico_objetivo_info_id')->references('id')->on('tab_publico_objetivo');
            $table->integer('procesados');
            $table->integer('resultado');
            $table->dateTime('fecha_recepcion');
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
        Schema::dropIfExists('tab_resultado_sms');
    }
}
