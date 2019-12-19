<?php

use App\AddressStatus;
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
            $table->string('mak')->nullable();
            $table->unsignedSmallInteger('status')->default(AddressStatus::Unverified);
            $table->string('address')->nullable();
            $table->string('address_number');
            $table->string('street');
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('unit')->nullable();
            $table->string('room')->nullable();
            $table->string('additional')->nullable();
            $table->string('city');
            $table->string('county');
            $table->string('state');
            $table->unsignedInteger('zip');
            $table->unsignedInteger('zip4')->nullable();
            $table->string('address_type')->nullable();
            $table->dateTime('assigned')->nullable();
            $table->dateTime('completed')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
