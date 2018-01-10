<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDegreeCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degree_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('code');
            $table->string('name_ita');
            $table->string('name_eng');
            $table->boolean('is_international');

            $table->integer('university_branch_id')->unsigned();
            $table->foreign('university_branch_id')->references('id')->on('university_branches');

            $table->integer('degree_course_type_id')->unsigned();
            $table->foreign('degree_course_type_id')->references('id')->on('course_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degree_courses');
    }
}
