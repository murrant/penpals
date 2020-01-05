<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('address_id')->index();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('alternate_names')->nullable();
            $table->string('age_range')->nullable();
            $table->string('gender')->nullable();
            $table->string('link_to_address_start_date')->nullable();
            $table->string('relation')->default('Primary');
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
        Schema::dropIfExists('residents');
    }
}
