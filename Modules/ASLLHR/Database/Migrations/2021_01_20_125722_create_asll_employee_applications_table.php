<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblApplication', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->bigInteger('intApplicationTypeId');
            $table->bigInteger('intEmployeeId');
            $table->bigInteger('intRankId');
            $table->bigInteger('intVesselId');
            $table->string('strReceiverName');
            $table->string('dteFromDate');
            $table->string('strPortName');
            $table->text('strApplicationBody');
            $table->string('strCommencementTenure');
            $table->string('dteDateOfCompletion');
            $table->string('dteExtensionRequested');
            $table->string('dteRejoiningDate');
            $table->text('strRemarks');
            $table->string('strApplicationSubject');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblApplication');
    }
}
