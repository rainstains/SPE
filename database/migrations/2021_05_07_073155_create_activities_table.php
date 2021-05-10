<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('desc')->default('Description');
            $table->Date('date');
            $table->binary('photo')->nullable();
            $table->string('confirm')->default('Not Confirmed');
            $table->string('period')->nullable();
            $table->BigInteger('extracurricular_id')->unsigned();
            $table->foreign('extracurricular_id')->references('id')->on('extracurriculars')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
