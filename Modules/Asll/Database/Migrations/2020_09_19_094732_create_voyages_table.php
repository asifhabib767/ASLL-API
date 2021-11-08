<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *

     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyage', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17)->index();

            $table->string('strVesselName');

            $table->unsignedBigInteger('intFromPortID')->nullable()->index();
            $table->string('strFromPortName')->nullable();

            $table->unsignedBigInteger('intToPortID')->nullable()->index();
            $table->string('strToPortName')->nullable();

            $table->unsignedBigInteger('intVlsfoRob')->default(17);
            $table->unsignedBigInteger('intLsmgRob')->default(17);
            $table->unsignedBigInteger('intLubOilRob')->default(17);
            $table->unsignedBigInteger('intMeccRob')->default(17);
            $table->unsignedBigInteger('intAeccRob')->default(17);


            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
            $table->unsignedBigInteger('intDeletedBy')->nullable()->index();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();

            $table->foreign('intVesselID')->references('intID')->on('tblVessel');
            $table->foreign('intCargoTypeID')->references('intID')->on('tblCargoType');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyage');
    }
}
