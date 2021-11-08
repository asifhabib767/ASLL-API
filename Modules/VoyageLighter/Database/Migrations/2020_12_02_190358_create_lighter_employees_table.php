<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLighterEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblLighterEmployee', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intLighterId');
            $table->unsignedBigInteger('intEnroll');
            $table->unsignedBigInteger('intLighterEmployeeId');
            $table->string('strLighterEmployeeName');
            $table->unsignedBigInteger('intEmployeeType');

            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intDeletedBy')->nullable();

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
        Schema::connection('DB_ASLL')->dropIfExists('tblLighterEmployee');
    }
}
