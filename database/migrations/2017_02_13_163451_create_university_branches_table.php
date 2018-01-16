<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversityBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('university_branches', function (Blueprint $table) {
            // Application essential columns
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            // University branch data
            $table->string('name');
            $table->string('name_eng')->nullable();
            $table->string('erasmus_code');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->integer('contact_person_id')->unsigned()->nullable();

            // Agreement data
            $table->date('first_semester_deadline')->nullable();
            $table->date('second_semester_deadline')->nullable();
            $table->date('expiration_date');
            $table->string('language_level')->nullable();
            $table->json('iad_levels')->nullable(); // Accepted DegreeCourseTypes

            // TODO consider referencing the max_outgoing field to an external table with timestamps
            $table->integer('max_outgoing')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('university_branches');
    }
}
