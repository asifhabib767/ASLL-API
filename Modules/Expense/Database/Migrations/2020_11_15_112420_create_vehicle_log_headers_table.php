<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleLogHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblVehicleLogHeader', function (Blueprint $table) {
            $table->bigIncrements('intVehicleLogHeaderId');
            $table->string('strTravelCode');
            $table->date('dteTravelDate');
            $table->unsignedBigInteger('intAccountId')->nullable();
            $table->unsignedBigInteger('intBusinessUnitId')->nullable();
            $table->string('strBusinessUnitName')->nullable();
            $table->boolean('ysnActive')->default(true);
            $table->string('strTotalOvertime');

            $table->boolean('ysnComplete')->default(false);
            $table->unsignedBigInteger('intActionBy')->nullable();
            $table->dateTime('dteLastActionDateTime')->nullable();
            $table->dateTime('dteServerDateTime')->nullable();

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
        Schema::connection('ERP_Apps')->dropIfExists('tblVehicleLogHeader');
    }
}
