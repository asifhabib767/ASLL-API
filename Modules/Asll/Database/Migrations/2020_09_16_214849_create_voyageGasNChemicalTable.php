<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageGasNChemicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageGasNChemical', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageID');
            $table->unsignedBigInteger('intVoyageActivityID');
            $table->unsignedBigInteger('intVoyageActivityGasNChemicalMainID');
            $table->unsignedBigInteger('intGasNChemicalId');
            $table->string('strGasNChemicalName');
            $table->unsignedBigInteger('decBFWD');
            $table->unsignedBigInteger('decRecv');
            $table->unsignedBigInteger('decCons');
            $table->unsignedBigInteger('dectotal');
            

            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intDeletedBy')->nullable();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageGasNChemical');
    }
}
