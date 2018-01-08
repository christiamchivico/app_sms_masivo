<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabFechaEnvioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_fecha_envio', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_envio');
            $table->integer('tab_campana_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('tab_campana_id')->references('id')->on('tab_campana');
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
        Schema::dropIfExists('tab_fecha_envio');
    }
}
