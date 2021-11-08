<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageActivityExhtEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageActivityExhtEngine', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageActivityID');
            $table->unsignedInteger('intShipEngineID');
            $table->string('strShipEngineName');

            $table->float('dceMainEngineFuelRPM')->default(0)->nullable();
            $table->float('dceRH')->default(0)->nullable();
            $table->float('dceLoad')->default(0)->nullable()->comment('in KW');
            $table->float('dceExhtTemp1')->default(0)->nullable();
            $table->float('dceExhtTemp2')->default(0)->nullable();

            $table->float('dceJacketTemp')->default(0)->nullable();
            $table->float('dceScavTemp')->default(0)->nullable();
            $table->float('dceLubOilTemp')->default(0)->nullable();
            $table->float('dceTCRPM')->default(0)->nullable();
            $table->float('dceJacketPressure')->default(0)->nullable();
            $table->float('dceScavPressure')->default(0)->nullable();
            $table->float('dceLubOilPressure')->default(0)->nullable();
            $table->string('strRemarks');

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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageActivityExhtEngine');
    }
}
