<?php

use App\AddressStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ComplexAddressStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'addresses';
        if ('sqlsrv' == DB::connection()->getDriverName()) {
            $defaultContraint = DB::selectOne("SELECT OBJECT_NAME([default_object_id]) AS name FROM SYS.COLUMNS WHERE [object_id] = OBJECT_ID('[dbo].[$tableName]') AND [name] = 'valid'");
            DB::statement("ALTER TABLE [dbo].[$tableName] DROP CONSTRAINT $defaultContraint->name");
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn('valid');
            $table->unsignedSmallInteger('status')->default(AddressStatus::Unverified);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('valid')->default(false);
        });
    }
}
