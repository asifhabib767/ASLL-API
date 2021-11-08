<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateVoyageLighterMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageLighterMain', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->date('dteDate');
            $table->unsignedBigInteger('intLoadingPointId');
            $table->string('strLoadingPointName')->nullable();
            $table->unsignedBigInteger('intLighterId');
            $table->string('strLighterName');
            $table->string('strCode');
            $table->unsignedBigInteger('intLighterVoyageNo');
            $table->unsignedBigInteger('intMasterId');
            $table->string('strMasterName');
            $table->date('strUnloadStartDate')->nullable();
            $table->string('strUnloadCompleteDate')->nullable();
            $table->unsignedBigInteger('intDriverId')->nullable();
            $table->string('strDriverName')->nullable();
            $table->text('strComments')->nullable();
            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intDeletedBy')->nullable();
            $table->boolean('ysnActive')->default(1);
            $table->boolean('ysnCompleted')->default(1);
            $table->boolean('synced')->default(1);
            $table->float('decTripCost')->nullable();
            $table->float('decPilotCoupon')->nullable();
            $table->float('decFreightRate')->nullable();
            $table->unsignedBigInteger('intSurveyNumber')->nullable();
            $table->string('strPartyName')->nullable();
            $table->string('strPartyCode')->nullable();
            $table->unsignedBigInteger('intMotherVesselID')->nullable();
            $table->string('strMotherVesselName')->nullable();
            $table->string('strPartyName')->nullable();
            $table->date('dteVoyageCommencedDate');
            $table->date('dteVoyageCompletionDate');
            $table->string('strDischargePortName')->nullable();
            $table->unsignedBigInteger('intDischargePortID')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageLighterMain');
    }
}
