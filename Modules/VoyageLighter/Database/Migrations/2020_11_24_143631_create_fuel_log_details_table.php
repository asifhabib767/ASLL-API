<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelLogDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblFuelLogDetails', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intLighterId');
            $table->unsignedBigInteger('intFuelLogId');
            $table->unsignedBigInteger('intFuelTypeId');
            $table->string('strFuelTypeName')->nullable();
            $table->float('decFuelPrice')->default(0);
            $table->float('decFuelQty')->default(0);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblFuelLogDetails');
    }
}
