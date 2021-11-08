<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVesselTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVesselType', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17);
            $table->string('strName');
            $table->boolean('ysnActive')->default(1);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVesselType');
    }
}
