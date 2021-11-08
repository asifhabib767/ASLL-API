<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblExpenseRegisterHeader', function (Blueprint $table) {
            $table->bigIncrements('intExpenseId');
            $table->string('strExpenseCode');
            $table->unsignedBigInteger('intBusinessUnitId');
            $table->string('intBusinessUnitName')->nullable();

            $table->unsignedBigInteger('intExpenseCategoryId');
            $table->string('strExpenseCategoryName')->nullable();

            $table->unsignedBigInteger('intSBUId')->nullable();
            $table->string('strSBUName')->nullable();

            $table->unsignedBigInteger('intCountryId')->nullable();
            $table->string('strCountryName')->nullable();

            $table->unsignedBigInteger('intCurrencyId')->nullable();
            $table->string('strCurrencyName')->nullable();

            $table->unsignedBigInteger('intExpenseForId')->nullable();
            $table->date('dteFromDate')->nullable();
            $table->date('dteToDate')->nullable();

            $table->unsignedBigInteger('intProjectId')->nullable();
            $table->string('strProjectName')->nullable();

            $table->unsignedBigInteger('intCostCenterId')->nullable();
            $table->string('strCostCenterName')->nullable();

            $table->unsignedBigInteger('intInstrumentId')->nullable();
            $table->string('strInstrumentName')->nullable();

            $table->unsignedBigInteger('intDisbursementCenterId')->nullable();
            $table->string('strDisbursementCenterName')->nullable();

            $table->string('strReferenceNo')->nullable();
            $table->float('numTotalAmount')->default(0);
            $table->float('numTotalApprovedAmount')->default(0);
            $table->float('numAdjustmentAmount')->default(0);
            $table->float('numPendingAmount')->default(0);
            $table->text('strComments')->nullable();

            $table->boolean('ysnComplete')->default(true);
            $table->boolean('ysnActive')->default(true);
            $table->boolean('ysnApproveBySupervisor')->default(false);
            $table->boolean('ysnApproveByHR')->default(false);
            $table->boolean('ysnApproveByAudit')->default(false);
            $table->integer('intApproveBySupervisor')->nullable();
            $table->integer('intApproveByHR')->nullable();
            $table->integer('intApproveByAudit')->nullable();


            $table->unsignedBigInteger('intActionBy')->nullable();
            $table->dateTime('dteLastActionDateTime')->nullable();
            $table->dateTime('dteServerDateTime')->nullable();

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
        Schema::connection('ERP_Apps')->dropIfExists('tblExpenseRegisterHeader');
    }
}
