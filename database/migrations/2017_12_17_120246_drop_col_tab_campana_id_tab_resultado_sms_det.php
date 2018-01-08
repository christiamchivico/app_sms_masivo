<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColTabCampanaIdTabResultadoSmsDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_resultado_sms_det', function (Blueprint $table) {
                $table->dropForeign(['tab_campana_id']);
                $table->dropForeign(['tab_resultado_sms_id']);
                $table->dropColumn(['tab_campana_id','tab_resultado_sms_id']);
            });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
