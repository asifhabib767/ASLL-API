<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselItem', function (Blueprint $table) {
            $table->id('intID');
            $table->string('strVesselItemName')->nullable();
            $table->integer('intVesselId');
            $table->string('strVesselName')->nullable();
            $table->float('decQtyAvailable')->nullable();
            $table->float('decDefaultPurchasePrice')->nullable();
            $table->float('decDefaultSalePrice')->nullable();
            $table->integer('intItemTypeId')->nullable();
            $table->string('strItemTypeName')->nullable();
            $table->integer('intCreatedBy')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselItem');
    }
}
