<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabCampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tab_campana', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('asunto');
            $table->string('email_emisor');
            $table->string('email_respuesta');
            $table->integer('cat_categoria_campana_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('cat_categoria_campana_id')->references('id')->on('cat_categoria_campana');
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
        Schema::dropIfExists('tab_campana');
    }
}
