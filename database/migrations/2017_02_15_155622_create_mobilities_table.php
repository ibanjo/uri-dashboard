<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobilities', function (Blueprint $table) {
            // Application essential columns
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            // FIXME temporary before full programmes table implementation
            $table->string('programme_name');

            // Mobility person, status and location
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('mobility_status_id')->unsigned()->default(1);
            $table->foreign('mobility_status_id')->references('id')->on('mobility_statuses');

            $table->integer('university_branch_id')->unsigned();
            $table->foreign('university_branch_id')->references('id')->on('university_branches');

            $table->string('academic_year');

            // Estimated mobility data
            $table->integer('semester_id')->unsigned();
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->date('estimated_in');
            $table->date('estimated_out');
            $table->unsignedSmallInteger('estimated_cfu_exams');
            $table->unsignedSmallInteger('estimated_cfu_thesis');

            $table->string('contract_number')->nullable();
            $table->boolean('granted')->nullable();

            // Transcript data
            $table->unsignedSmallInteger('transcript_cfu_exams')->nullable();
            $table->unsignedSmallInteger('transcript_cfu_thesis')->nullable();
            $table->date('acknowledged_in')->nullable();
            $table->date('acknowledged_out')->nullable();

            // Acknowledgement data
            $table->unsignedSmallInteger('acknowledged_cfu_exams')->nullable();
            $table->unsignedSmallInteger('acknowledged_cfu_thesis')->nullable();
            $table->unsignedSmallInteger('acknowledged_cfu_supernumerary')->nullable();
            $table->mediumInteger('extension')->unsigned()->nullable(); // Mobility extension in days

            // Money grants (in Euro)
            $table->decimal('eu_grant', 15, 2)->nullable();
            $table->decimal('travel_grant', 15, 2)->nullable();
            $table->decimal('spent_grant', 15, 2)->nullable();
            $table->json('other_funding')->nullable();

            $table->string('abortion_notes')->nullable();
            $table->text('notes')->nullable(); // General purpose note field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobilities');
    }
}
