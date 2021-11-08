<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllCRRreportsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCRReport', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intEmployeeId');
            $table->bigInteger('intRankId');
            $table->bigInteger('intVesselId');
            $table->string('dteFromDate');
            $table->string('dteToDate');
            $table->string('strReasonOfAppraisal');
            $table->string('strOverallPerformance');
            $table->boolean('ysnPromotionRecomanded');
            $table->boolean('ysnFurtherRecomanded');
            $table->string('strPromotionRecomandedDate');
            $table->string('strFurtherRecomandedDate');
            $table->string('strMasterSign');
            $table->string('strCESign');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblCRReport');
    }
}
