<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSignInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblEmployeeSignInOut', function (Blueprint $table) {
            $table->id('intID');
            $table->unsignedBigInteger('intEmployeeId');
            $table->unsignedBigInteger('intVesselId');
            $table->string('dteActionDate');
            $table->boolean('ysnSignIn');
            $table->string('strRemarks')->nullable();
            $table->integer('intLastVesselId')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblEmployeeSignInOut');
    }
}
