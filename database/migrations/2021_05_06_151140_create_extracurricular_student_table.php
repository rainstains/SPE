<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtracurricularStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extracurricular_student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->string('angkatan');
            $table->BigInteger('extracurricular_id')->unsigned();
            $table->BigInteger('student_id')->unsigned();
            $table->foreign('extracurricular_id')->references('id')->on('extracurriculars')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extracurricular_student');
    }
}
