<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            // Application essential columns
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            // Country related data
            $table->string('name_ita');
            $table->string('name_eng');

            // TODO consider referencing the monthly grant field to an external table with timestamps
            $table->integer('monthly_grant');
            $table->integer('travel_grant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
