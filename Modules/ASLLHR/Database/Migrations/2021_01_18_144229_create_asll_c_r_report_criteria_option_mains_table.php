<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllCRReportCriteriaOptionMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCRReportCriteriaOptionMain', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intCriteriaMainId');
            $table->string('strName');

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
        Schema::connection('DB_ASLL')->dropIfExists('tblCRReportCriteriaOptionMain');
    }
}
