<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselAccountBaolancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselAccountBalance', function (Blueprint $table) {
            $table->id('intID');
            $table->unsignedBigInteger('intVesselId');
            $table->unsignedBigInteger('intVesselAccountId');
            $table->unsignedInteger('intYear');
            $table->unsignedInteger('intMonth');
            $table->date('dteDate');
            $table->float('decOpeningBalance')->default(0);
            $table->float('decClosingBalance')->default(0);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselAccountBalance');
    }
}
