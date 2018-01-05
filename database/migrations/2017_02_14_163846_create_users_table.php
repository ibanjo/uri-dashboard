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
            // Application essential columns
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            // Login and contact info
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('password');
            $table->rememberToken();

            // Basic data
            $table->string('name');
            $table->string('middle_name')->nullable();
            $table->string('surname');
            $table->string('fiscal_code');
            $table->string('profile_picture')->nullable();

            // Workplace/academic data
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');

            $table->integer('role_id')->unsigned()->default(6);
            $table->foreign('role_id')->references('id')->on('roles');

            $table->integer('candidate_role_id')->unsigned()->default(6);
            $table->foreign('candidate_role_id')->references('id')->on('roles');

            //$table->string('degree_course'); // FIXME degree_course might be chosen from a fixed list
            $table->integer('degree_course_id')->unsigned();
            $table->foreign('degree_course_id')->references('id')->on('degree_courses');

            // Bank data
            $table->integer('active_bank_account_id')->unsigned()->nullable();
        });
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
