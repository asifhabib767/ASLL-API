<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllHrEmployeeEducationTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployeeEducation', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('image')->nullable();
            $table->string('strCertification');
            $table->string('strInstitution')->nullable();
            $table->string('strYear')->nullable();
            $table->string('strResult')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployeeEducation');
    }
}
