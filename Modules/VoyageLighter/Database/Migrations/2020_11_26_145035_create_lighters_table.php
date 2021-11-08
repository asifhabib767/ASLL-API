<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLightersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblLighter', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intLighterId');
            $table->string('strLighterName');
            $table->string('strType');
            $table->unsignedBigInteger('intTypeId');
            $table->unsignedBigInteger('intMasterId');
            $table->string('strMasterName');
            $table->unsignedBigInteger('intDriverId');
            $table->string('strDriverName');

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
        Schema::connection('DB_ASLL')->dropIfExists('tblLighter');
    }
}
