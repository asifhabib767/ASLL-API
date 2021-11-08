<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotherVesselDemandSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselDemandSheet', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->date('dteLayCanFromDate');
            $table->date('dteLayCanToDate');
            $table->integer('intCountryID');
            $table->string('strCountry');
            $table->float('decGrandQuantity');
            $table->date('dteETADateFromLoadPort');
            $table->date('dteETADateToLoadPort');
            $table->string('strComments');
            $table->boolean('ysnActive')->default(1);
            $table->unsignedBigInteger('intCreatedBy');
            $table->unsignedBigInteger('intUpdatedBy');
            $table->unsignedBigInteger('intDeletedBy');
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            $table->unsignedBigInteger('intPortFrom');
            $table->unsignedBigInteger('strPortFrom');
            $table->unsignedBigInteger('intPortTo');
            $table->unsignedBigInteger('strPortTo');
            $table->unsignedBigInteger('strImagePath');
            $table->unsignedBigInteger('strLCNumber');
            $table->unsignedBigInteger('strBLNumber');
            $table->unsignedBigInteger('strCPControl');
            $table->unsignedBigInteger('strVoyageNumber');
            $table->integer('intCharterer');
            $table->string('strCharterer');
            $table->integer('intShipper');
            $table->string('strShipper');


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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselDemandSheet');
    }
}
