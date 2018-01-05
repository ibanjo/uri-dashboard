<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            // Essential columns
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            // Role name and description
            $table->string('name');
            $table->text('description');
            $table->boolean('hidden')->default(false); // Not to be shown in registration form
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
