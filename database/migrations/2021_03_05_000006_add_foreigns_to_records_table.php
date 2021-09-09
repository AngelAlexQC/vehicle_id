<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('parking_id')
                ->references('id')
                ->on('parkings');
            $table
                ->foreign('driver_id')
                ->references('id')
                ->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['parking_id']);
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['vehicle_id']);
        });
    }
}
