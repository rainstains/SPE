<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role');
            $table->BigInteger('ekskul_id')->nullable()->unsigned();
            $table->foreign('ekskul_id')->references('id')->on('ekstrakurikuler');
            $table->rememberToken();
            $table->timestamps();
        });
        // Insert User Admin
        DB::table('users')->insert(
            array(
                'firstname' => 'Alina',
                'lastname' => 'Starkov',
                'username' => 'adminAlina',
                'password' => Hash::make('AlinaisAdmin'),
                'role' => 'ADMIN',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            )
        );
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
