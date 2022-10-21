<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentaswers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('answer_id');
            $table->unsignedBigInteger('student_id');
            $table->boolean('is_faine')->nullable(false)->default(false);
            $table->timestamps();

            $table->foreign('answer_id')->references('id')->on('answers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentaswers');
    }
}
