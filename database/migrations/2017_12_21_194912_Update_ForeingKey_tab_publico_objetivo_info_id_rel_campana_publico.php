<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeingKeyTabPublicoObjetivoInfoIdRelCampanaPublico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_campana_publico', function (Blueprint $table) {
                $table->dropForeign(['tab_publico_objetivo_info_id']);
                $table->foreign('tab_publico_objetivo_info_id')->references('id')->on('tab_publico_inf');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
