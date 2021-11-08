<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselAccount', function (Blueprint $table) {
            $table->id('intID');
            $table->integer('intVesselId');
            $table->string('strVesselName')->nullable();
            $table->float('decBondAccountBalance')->nullable();
            $table->float('decCashAccountBalance')->nullable();
            $table->string('intCreatedBy')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselAccount');
    }
}
