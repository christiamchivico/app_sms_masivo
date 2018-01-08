<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabPrecioSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_precio_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('costo_sms');
            $table->integer('tab_empresa_id')->unsigned()->nullable();
            $table->foreign('tab_empresa_id')->references('id')->on('tab_empresa');
            $table->integer('saldo')->unsigned()->nullable();
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
        Schema::dropIfExists('tab_precio_sms');
    }
}
