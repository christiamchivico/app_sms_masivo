<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColStatusTabCampana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tab_campana', function (Blueprint $table) {
                $table->enum('status',['0','1'])->after('mensaje_sms')->default('0');
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
                $table->dropColumn('status');
            });
    }
}
