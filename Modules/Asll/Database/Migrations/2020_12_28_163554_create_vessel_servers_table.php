<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblVesselServer', function (Blueprint $table) {
            $table->id('id');
            $table->string('ip');
            $table->string('vesselName')->nullable();
            $table->unsignedBigInteger('createdBy')->nullable();
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

        Schema::connection('ERP_Apps')->dropIfExists('tblVesselServer');
    }
}
