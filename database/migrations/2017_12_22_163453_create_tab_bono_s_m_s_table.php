<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabBonoSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_bono_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('total_sms');
            $table->integer('restantes_sms');
            $table->integer('tab_empresa_id')->unsigned()->nullable();
            $table->foreign('tab_empresa_id')->references('id')->on('tab_empresa');
            $table->dateTime('fecha_inicio'); 
            $table->dateTime('fecha_final'); 
            $table->integer('activo');
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
        Schema::dropIfExists('tab_bono_sms');
    }
}
