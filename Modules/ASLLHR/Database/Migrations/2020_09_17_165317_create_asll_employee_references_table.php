<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployeeReference', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('image')->nullable();
            $table->string('strCompanyName')->nullable();
            $table->string('strCountry')->nullable();
            $table->string('strEmail')->nullable();
            $table->string('strPersonName')->nullable();
            $table->string('strTelephone')->nullable();
            $table->string('strAddress')->nullable();
            $table->string('isVisa')->nullable();
            $table->string('maritimeAccident')->nullable();
            $table->integer('intEmployeeId')->nullable();
            $table->integer('intUnitId')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployeeReference');
    }
}
