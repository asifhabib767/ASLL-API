<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // strBillDate ,decStartime ,decEndtime , decMovDuration,strPurpouse,purpid ,intSl,tmStart,tmEnd,tmDifference
        // ,Applicantenrol ,dteInsertionDate ,intEnroll 

        Schema::connection('ERP_HR')->create('tblEmployeeTimeSheet', function (Blueprint $table) {
            $table->bigIncrements('intTimsheetId');
            $table->unsignedBigInteger('intUnitId');

            $table->unsignedBigInteger('dteBillDate')->nullable()->index();
            $table->unsignedBigInteger('decStartime')->nullable()->index();
            $table->unsignedBigInteger('decEndtime')->nullable()->index();

            $table->unsignedBigInteger('decMovDuration')->nullable()->index();
            $table->unsignedBigInteger('strNotes')->nullable()->index();
            $table->unsignedBigInteger('intPurpouseId')->nullable()->index();

            $table->unsignedBigInteger('intApplicantenrol')->nullable()->index();
            $table->unsignedBigInteger('intInsertBy')->nullable()->index();
            $table->unsignedBigInteger('dteInsertionDate')->nullable()->index();
            $table->unsignedBigInteger('ysnActive')->nullable()->index();




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
        Schema::connection('ERP_HR')->dropIfExists('tblEmployeeTimeSheet');
    }
}
