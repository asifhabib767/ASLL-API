<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLighterLoadingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblLighterLoadingPoint', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strLoadingPointName');
            $table->date('dteCompletionDate');
            $table->integer('intVesselTypeOrPointTypeID');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblLighterLoadingPoint');
    }
}
