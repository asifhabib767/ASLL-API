<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllCrCriteriaOptionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCRCriteriaOptionResponse', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intCriteriaMainId');
            $table->bigInteger('intCrReportId');
            $table->bigInteger('intOptionMainId');
            $table->string('strOptionValue');
            $table->boolean('ysnIsChecked')->default(0);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblCRCriteriaOptionResponse');
    }
}
