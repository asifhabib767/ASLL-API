<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpeningClosingAccountsTable extends Migration
{
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblOpeningClosingAccount', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intEmployeeId')->nullable();
            $table->bigInteger('intAdditionDeductionTypeId')->nullable();
            $table->bigInteger('intVesselId')->nullable();
            $table->float('decOpening');
            $table->float('decReceive');
            $table->float('decIssue');
            $table->float('decClosing');
            $table->date('dteActionDate');
            $table->integer('intActionBy');
            $table->string('strRemarks');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblOpeningClosingAccount');
    }
}
