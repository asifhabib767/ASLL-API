<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblVehicleLog', function (Blueprint $table) {
            $table->bigIncrements('intVehicleLogId');
            $table->unsignedBigInteger('intVehicleLogHeaderId');
            $table->string('strTravelCode');
            $table->date('dteTravelDate');
            $table->unsignedBigInteger('intAccountId')->nullable();
            $table->unsignedBigInteger('intBusinessUnitId')->nullable();
            $table->string('strBusinessUnitName')->nullable();

            $table->dateTime('dteStartTime');
            $table->dateTime('dteEndTime');
            $table->string('strOverTime');

            $table->string('strFromAddress')->nullable();
            $table->string('strToAddress')->nullable();

            $table->unsignedBigInteger('IntVehicleId')->nullable();
            $table->string('strVehicleNumber')->nullable();

            $table->float('numVehicleStartMileage')->default(0);
            $table->float('numVehicleEndMileage')->default(0);
            $table->float('numVehicleConsumedMileage')->default(0);

            $table->unsignedBigInteger('intDriverId')->nullable();
            $table->string('strDriverName')->nullable();

            $table->unsignedBigInteger('intSBUId')->nullable();
            $table->string('strSBUName')->nullable();

            $table->float('numRate')->default(0);
            $table->float('numAmount')->default(0);
            $table->text('strExpenseLocation')->nullable();
            $table->text('strVisitedPlaces')->nullable();

            $table->text('strAttachmentLink')->nullable();

            $table->boolean('isFuelPurchased')->default(false);
            $table->string('strPersonalUsage');
            $table->boolean('ysnActive')->default(true);
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
        Schema::connection('ERP_Apps')->dropIfExists('tblVehicleLog');
    }
}
