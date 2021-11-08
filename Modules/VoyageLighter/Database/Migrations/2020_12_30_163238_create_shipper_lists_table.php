<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipperListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblShipperList', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strShipperName');
            $table->boolean('ysnActive');
            $table->integer('intCreatedBy');
            $table->integer('intUpdatedBy');
         
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
        Schema::connection('DB_ASLL')->dropIfExists('tblShipperList');
    }
}
