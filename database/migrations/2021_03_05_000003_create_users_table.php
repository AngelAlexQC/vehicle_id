<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identicador para el sistema');
            $table->string('dni', 10)->unique()->comment('Cédula del usuario');
            $table->string('name')->comment('Nombre del usuario');
            $table->string('photoURL')->nullable()->comment('Foto del Usuario');
            $table->string('email')->comment('Correo Electrónico del Usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('Contraseña encriptada del usuario');
            $table->string('remember_token', 100)->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
        User::create([
            'name' => 'Administrador',
            'dni' => '0987654321',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);
        User::create([
            'name' => 'Juan Bonilla',
            'dni' => '0999999999',
            'email' => 'juan@bonilla.com',
            'password' => Hash::make('juanbonilla')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
