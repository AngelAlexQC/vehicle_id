<?php

use App\Models\Vehicle;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate')->unique()->comment('Placa del vehículo');
            $table->string('brand')->comment('Marca del Mehículo');
            $table->string('registration')->unique()->comment('Matrícula del Vehículo');
            $table->string('model')->comment('Modelo del Vehículo');
            $table->unsignedBigInteger('owner_id')->comment('Propietario del vehículo');

            $table->index('plate');

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
        Schema::dropIfExists('vehicles');
    }
}
