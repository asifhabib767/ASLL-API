<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeamandSheetAprvDetaillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselDemandSheetApproveDetaills', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intVesselDemandSheetAprvID');
            $table->integer('intItemId');
            $table->string('strItemName');
            $table->float('intQuantity');
         
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselDemandSheetApproveDetaills');
    }
}
