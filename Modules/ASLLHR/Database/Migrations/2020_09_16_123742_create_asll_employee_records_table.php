<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployeeRecord', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strRank')->nullable();
            $table->string('strShipManager');
            $table->string('strVesselName')->nullable();
            $table->string('strFlag')->nullable();
            $table->string('strVesselType')->nullable();
            $table->string('strDWT')->nullable();
            $table->string('strEngineName')->nullable();
            $table->string('strFromDate')->nullable();
            $table->string('strToDate')->nullable();
            $table->string('strDuration')->nullable();
            $table->string('strReason')->nullable();
            $table->integer('intEmployeeId')->nullable();
            $table->integer('intUnitId')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployeeRecord');
    }
}
