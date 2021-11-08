<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryBulkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblSalaryBulkData', function (Blueprint $table) {
            $table->id('intID');
            $table->string('strOfficerName')->nullable();
            $table->string('strAdditionDeductionTypeName')->nullable();
            $table->integer('intAdditionDeductionTypeId')->nullable();
            $table->string('strRank')->nullable();
            $table->string('strCDCNo')->nullable();
            $table->decimal('decWagesMonth')->nullable();
            $table->string('strRemarks')->nullable();
            $table->decimal('decEarningOfMonth')->nullable();
            $table->integer('intPreviousBalance')->nullable();
            $table->decimal('decAddIEarning')->nullable();
            $table->decimal('decTotalEarning')->nullable();
            $table->decimal('decAdvanceonBoard')->nullable();
            $table->decimal('decFbbCallingCard')->nullable();
            $table->decimal('decBondedItems')->nullable();
            $table->decimal('decJoiningAdvance')->nullable();
            $table->decimal('decTotalDeduction')->nullable();
            $table->decimal('decPayableAmount')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblSalaryBulkData');
    }
}
