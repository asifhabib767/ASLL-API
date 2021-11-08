<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployDutiesTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_HR')->create('tblEmployeeDuty', function (Blueprint $table) {
            $table->bigIncrements('intDutyAutoID');
            $table->unsignedBigInteger('intTrackingID');
            $table->unsignedBigInteger('intEmployeeID');
            $table->unsignedBigInteger('intEmployeeTypeID')->nullable();
            $table->string('strLocation')->nullable();
            $table->string('decLatitude')->nullable();
            $table->string('decLongitude')->nullable();
            $table->string('ysnVisited')->default(false);
            $table->dateTime('intAssignedBy')->nullable();
            $table->dateTime('strRemarks')->nullable();
            $table->string('intContactID')->nullable();
            $table->string('strContacName')->nullable();
            $table->boolean('ysnEnable')->nullable();
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
        Schema::connection('ERP_HR')->dropIfExists('tblEmployeeDuty');
    }
}
