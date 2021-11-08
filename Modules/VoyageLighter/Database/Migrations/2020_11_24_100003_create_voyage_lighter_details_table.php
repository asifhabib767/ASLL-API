<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageLighterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageLighterDetails', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageLighterId');
            $table->unsignedBigInteger('intItemId');
            $table->string('strItemName');
            $table->unsignedBigInteger('intQuantity')->default(0);

            $table->unsignedBigInteger('intVesselId')->nullable();
            $table->string('strVesselName')->nullable();
            $table->date('dteETAVessel')->nullable();
            $table->unsignedBigInteger('intVoyageId')->nullable();
            $table->unsignedBigInteger('intVoyageNo')->nullable();
            $table->string('strLCNo')->nullable();

            $table->unsignedBigInteger('intBoatNoteQty')->default(0);
            $table->unsignedBigInteger('intSurveyNo')->default(0);
            $table->unsignedBigInteger('intSurveyQty')->default(0);

            $table->boolean('ysnActive')->default(1);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageLighterDetails');
    }
}
