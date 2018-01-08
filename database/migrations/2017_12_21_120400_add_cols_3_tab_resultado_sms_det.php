<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCols3TabResultadoSmsDet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_resultado_sms_det', function (Blueprint $table) {
            $table->integer('caracteres')->after('resultado_t');
            $table->integer('costo')->after('caracteres');
            $table->string('ip')->after('costo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['caracteres', 'costo', 'ip']);
        });
    }
}
