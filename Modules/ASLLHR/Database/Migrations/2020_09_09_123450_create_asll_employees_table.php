<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployee', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strName');
            $table->string('intVesselID')->nullable()->comment('Current Vessel ID');
            $table->string('image')->nullable();
            $table->string('strBirthdate')->nullable();
            $table->string('strBirthPlace')->nullable();
            $table->string('strHomeTelephone')->nullable();
            $table->string('strRank')->nullable();
            $table->string('strAvailabilityDate')->nullable();
            $table->string('strEmail')->nullable();
            $table->string('strHeight')->nullable();
            $table->string('strWeight')->nullable();
            $table->string('strNationality')->nullable();
            $table->string('strEmgrPersonalTel')->nullable();
            $table->string('strEmgrPersonName')->nullable();
            $table->string('strEmgrPersonRelation')->nullable();
            $table->string('strEmgrPersonAddress')->nullable();
            $table->string('strTradingArea')->nullable();
            $table->string('strCargoCarried')->nullable();
            $table->string('strNearestAirport')->nullable();
            $table->unsignedBigInteger('intAirportId')->nullable();
            $table->string('strCurrency')->nullable();
            $table->unsignedBigInteger('intCurrencyId')->nullable();
            $table->string('strAmount')->nullable();
            $table->string('strBoilersuit')->nullable();
            $table->string('strSafetyShoes')->nullable();
            $table->string('strUniformShirt')->nullable();
            $table->string('strUniformTrouser')->nullable();
            $table->string('strWinterJacket')->nullable();
            $table->string('strPermanentAddress')->nullable();
            $table->string('strPresentAddress')->nullable();
            $table->string('strRemarks')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployee');
    }
}
