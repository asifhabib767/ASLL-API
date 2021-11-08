<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageActivity', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17)->index();

            $table->unsignedBigInteger('intVoyageID');
            $table->unsignedBigInteger('intShipPositionID');
            $table->unsignedBigInteger('intShipConditionTypeID')->nullable();
            $table->dateTime('dteCreatedAt')->default(Carbon::now());

            $table->float('decLatitude')->default(0);
            $table->float('decLongitude')->default(0);
            $table->unsignedInteger('intCourse')->default(0)->comment('0-360');

            // Sea
            $table->string('timeSeaStreaming')->nullable();
            $table->string('timeSeaStoppage')->nullable();
            $table->float('decSeaDistance')->default(0)->nullable();
            $table->float('decSeaDailyAvgSpeed')->default(0)->nullable();
            $table->float('decSeaGenAvgSpeed')->default(0)->nullable();
            $table->string('strSeaDirection')->nullable();
            $table->string('strSeaState')->nullable();

            $table->unsignedBigInteger('intETAPortToID')->nullable();
            $table->string('strETAPortToName')->nullable();
            $table->dateTime('strETADateTime')->nullable();

            // Port 
            $table->unsignedBigInteger('intVoyagePortID')->nullable();
            $table->float('decTimePortWorking')->default(0)->nullable();
            $table->string('strPortDirection')->nullable();
            $table->string('strPortDSS')->nullable();
            $table->unsignedBigInteger('intETDPortToID')->nullable();
            $table->string('strETDPortToName')->nullable();
            $table->dateTime('strETDDateTime')->nullable();
            $table->float('decCargoTobeLD')->default(0)->nullable();
            $table->float('decCargoPrevLD')->default(0)->nullable();
            $table->float('decCargoDailyLD')->default(0)->nullable();
            $table->float('decCargoTTLLD')->default(0)->nullable();
            $table->float('decCargoBalanceCGO')->default(0)->nullable();

            $table->string('strWindDirection')->nullable();
            $table->float('decWindBF')->default(0)->nullable();

            // Engineer
            $table->string('strRPM')->nullable();
            $table->float('decEngineSpeed')->default(0)->nullable();
            $table->float('decSlip')->default(0)->nullable()->comment('as %');


            $table->text('strRemarks')->nullable();
            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intApprovedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
            $table->unsignedBigInteger('intDeletedBy')->nullable()->index();
            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();

            $table->foreign('intVoyageID')->references('intID')->on('tblVoyage');
            $table->foreign('intShipPositionID')->references('intID')->on('tblShipPosition');
            $table->foreign('intShipConditionTypeID')->references('intID')->on('tblShipConditionType');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageActivity');
    }
}
