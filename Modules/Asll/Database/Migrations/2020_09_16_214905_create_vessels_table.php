<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVessel', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17);
            $table->string('strVesselName');
            $table->string('strIMONumber');
            $table->unsignedBigInteger('intVesselTypeID');
            $table->string('strVesselTypeName');
            $table->unsignedBigInteger('intYardCountryId');
            $table->string('strYardCountryName');
            $table->string('strVesselFlag')->nullable();
            $table->float('numDeadWeight')->default(0);
            $table->float('numGrossWeight')->default(0);
            $table->float('numNetWeight')->default(0);
            $table->string('strBuildYear');
            $table->string('strEngineName');
            $table->unsignedInteger('intTotalCrew')->default(0);

            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intDeletedBy')->nullable();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();

            $table->foreign('intVesselTypeID')->references('intID')->on('tblVesselType');
            $table->foreign('intYardCountryId')->references('intID')->on('tblCountry');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVessel');
    }
}
