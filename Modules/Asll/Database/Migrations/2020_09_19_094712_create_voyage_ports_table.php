<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyagePortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblPortList', function (Blueprint $table) {
            $table->bigIncrements('intPortId');
            $table->string('strPortCode')->nullable();
            $table->string('strPortName');
            $table->string('strCountryCode')->nullable();
            $table->string('strCountryName')->nullable();
            $table->string('strLOCODE')->nullable();
            $table->boolean('isActive')->default(1);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblPortList');
    }
}
