<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColTabPublicoObejtivoInfoIdTabResultadoSmsDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_resultado_sms_det', function (Blueprint $table) {
                $table->renameColumn('tab_publico_obejtivo_info_id', 'tab_publico_objetivo_info_id');
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
