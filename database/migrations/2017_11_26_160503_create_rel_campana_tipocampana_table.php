<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelCampanaTipocampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_campana_tipocampana', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_tipo_campana_id')->unsigned()->nullable();//no todos pueden definir el genero
            $table->foreign('cat_tipo_campana_id')->references('id')->on('cat_tipo_campana');
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
        Schema::dropIfExists('rel_campana_tipocampana');
    }
}
