<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelRequistionsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_iApps')->create('tblRequisitionMain', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intUnitID');
            $table->integer('intSupplierID');
            $table->string('strSupplierName');
            $table->date('dteRequisitionDate');
            $table->integer('intEnrol');
            $table->unsignedInteger('intUseFor');
            $table->string('strUseForName');
            $table->string('strReceivedBy');
            $table->boolean('ysnActive')->default(1);

            $table->integer('intLastActionBy');
            $table->date('dteLastActionTime');
            $table->integer('intCostCenter');
            $table->integer('strIssueRemarks');
         


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
        Schema::connection('DB_iApps')->dropIfExists('tblRequisitionMain');
    }
}
