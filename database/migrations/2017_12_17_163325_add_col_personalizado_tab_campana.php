<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColPersonalizadoTabCampana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_campana', function (Blueprint $table) {
            $table->integer('personalizado')->after('tab_empresa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tab_campana', function (Blueprint $table) {
            $table->dropColumn('personalizado');
        });
    }
}
