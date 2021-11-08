<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselDemandSheetApprovesTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselDemandSheetApprove', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intVesselDemandSheetID');
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
         
            $table->integer('intPortFrom');
            $table->string('strPortFrom');
            $table->integer('intPortTo');
            $table->string('strPortTo');
            $table->string('strImagePath');
            $table->string('strLCNumber');
            $table->string('strBLNumber');
            $table->string('strCPControl');
            $table->string('strVoyageNumber');
        


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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselDemandSheetApprove');
    }
}
