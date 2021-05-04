<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->string('angkatan');
            $table->BigInteger('ekskul_id')->unsigned();
            $table->BigInteger('siswa_id')->unsigned();
            $table->foreign('ekskul_id')->references('id')->on('users');
            $table->foreign('siswa_id')->references('id')->on('siswa');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota');
    }
}
