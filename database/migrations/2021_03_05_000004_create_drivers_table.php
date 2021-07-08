<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dni', 10)->unique()->comment('Cédula del conductor');
            $table->string('name')->comment('Nombre del conductor');
            $table->string('surname')->comment('Apellido del Conductor');
            $table->string('email')->comment('email del conductor');
            $table->string('phone')->unique()->comment('Celular del conductor');

            $table->index('dni');

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
        Schema::dropIfExists('drivers');
    }
}
