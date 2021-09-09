<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identicador para el sistema');
            $table->string('dni')->comment('Cédula buscada')->nullable();
            $table->string('plate')->comment('Placa buscada')->nullable();
            $table->string('type')->comment('Entrada o Salida')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->comment('Usuario');
            $table->unsignedBigInteger('parking_id')->nullable()->comment('Parqueadero');
            $table->unsignedBigInteger('driver_id')->nullable()->comment('Conductor');
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
        Schema::dropIfExists('records');
    }
}
