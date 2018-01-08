<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCols3TabPrecioSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_precio_sms', function (Blueprint $table) {
                $table->integer('saldo_pendiente')->after('saldo');
                $table->enum('tipo_pago', ['pre', 'post'])->after('saldo_pendiente')->default('pre');
                $table->integer('restrinccion')->after('tipo_pago')->default(1);
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
                $table->dropColumn(['saldo_pendiente','tipo_pago','restrinccion']);
            });
    }
}
