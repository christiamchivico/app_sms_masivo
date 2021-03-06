<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColDescripcionTabPrecioSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_precio_sms', function (Blueprint $table) {
                $table->string('descripcion')->after('id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tab_precio_sms', function (Blueprint $table) {
                $table->dropColumn('descripcion');
            });
    }
}
