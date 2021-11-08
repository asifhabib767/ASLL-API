<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblEmployeeFinance', function (Blueprint $table) {
            $table->id('intID');
            $table->string('strTotalSupplyInput');
            $table->string('strPreviousMonth');
            $table->integer('intExpensetypeId');
            $table->string('strExpenseTypeName');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblEmployeeFinance');
    }
}
