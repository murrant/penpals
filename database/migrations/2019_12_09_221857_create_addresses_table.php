<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('penpal_id')->default(0)->index();
            $table->string('address');
            $table->string('house_number');
            $table->string('street');
            $table->string('street_name')->nullable();
            $table->string('street_suffix');
            $table->string('city');
            $table->string('state');
            $table->string('state_name');
            $table->unsignedSmallInteger('zip');
            $table->unsignedSmallInteger('zip4');
            $table->string('address_type');
            $table->string('rbdi');
            $table->string('fips');
            $table->string('county');
            $table->string('result_code');
            $table->unsignedBigInteger('mak')->unique();
            $table->dateTime('assigned')->nullable();
            $table->dateTime('mailed')->nullable();
            $table->timestamps();
        });
    }
    // HouseNumber	Street	StreetSuffix	City	State	Zip	StreetName	Address	StateName	Zip4	AddressType	RBDI	Fips	County	ResultCode	MAK

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
