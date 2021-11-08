<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageActivityEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageActivityMainEngine', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageActivityID');
            $table->unsignedInteger('intShipEngineID');
            $table->string('strShipEngineName');

            $table->float('dceJacketTemp1')->default(0)->nullable();
            $table->float('dceJacketTemp2')->default(0)->nullable();
            $table->float('dcePistonTemp1')->default(0)->nullable();
            $table->float('dcePistonTemp2')->default(0)->nullable();
            $table->float('dceExhtTemp1')->default(0)->nullable();
            $table->float('dceExhtTemp2')->default(0)->nullable();
            $table->float('dceScavTemp1')->default(0)->nullable();
            $table->float('dceScavTemp2')->default(0)->nullable();
            $table->float('dceTurboCharger1Temp1')->default(0)->nullable();
            $table->float('dceTurboCharger1Temp2')->default(0)->nullable();
            $table->float('dceEngineLoad')->default(0)->nullable();
            $table->float('dceJacketCoolingTemp1')->default(0)->nullable();
            $table->float('dcePistonCoolingTemp1')->default(0)->nullable();
            $table->float('dceLubOilCoolingTemp1')->default(0)->nullable();
            $table->float('dceFuelCoolingTemp1')->default(0)->nullable();
            $table->float('dceScavCoolingTemp1')->default(0)->nullable();

            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intApprovedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
            $table->unsignedBigInteger('intDeletedBy')->nullable()->index();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();

            $table->foreign('intVoyageActivityID')->references('intID')->on('tblVoyageACtivity');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageActivityMainEngine');
    }
}
