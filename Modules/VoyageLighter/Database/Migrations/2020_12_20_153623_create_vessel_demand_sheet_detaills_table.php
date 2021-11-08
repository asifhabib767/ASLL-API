<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselDemandSheetDetaillsTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselDemandSheetDetaills', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intVesselDemandSheetID');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselDemandSheetDetaills');
    }
}
