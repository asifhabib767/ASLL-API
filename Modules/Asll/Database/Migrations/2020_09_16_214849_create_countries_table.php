<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCountry', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strName');
            $table->string('strIso', 10)->nullable();
            $table->string('strIso3', 10)->nullable();
            $table->string('numCode', 10)->nullable();
            $table->unsignedInteger('intPhoneCode')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblCountry');
    }
}
