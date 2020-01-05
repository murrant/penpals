<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenpalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penpals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 150)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedSmallInteger('role');
            $table->string('phone', 32)->nullable();
            $table->string('address');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function getConnection()
    {
        return parent::getConnection(); // TODO: Change the autogenerated stub
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penpals');
    }
}
