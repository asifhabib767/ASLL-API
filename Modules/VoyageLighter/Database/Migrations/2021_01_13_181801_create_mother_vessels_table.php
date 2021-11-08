<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotherVesselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblMotherVesselForLighter', function (Blueprint $table) {
            $table->bigIncrements('intVesselID');
            $table->string('strVesselName');
            $table->date('dteInsertDate');

            $table->boolean('isActive')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('DB_ASLL')->dropIfExists('tblMotherVesselForLighter');
    }
}
