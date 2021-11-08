<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisitionDetsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_iApps')->create('tblRequisitionDetaills', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intReqID');
            $table->integer('intItemID');

            $table->string('strItemName');
            $table->float('numReqQty');
            $table->float('numIssueQty');
         
            $table->string('strIssueRemarks');
         


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
        Schema::connection('DB_iApps')->dropIfExists('tblRequisitionDetaills');
    }
}
