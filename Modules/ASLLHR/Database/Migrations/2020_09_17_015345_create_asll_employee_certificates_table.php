<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeCertificatesTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployeeCertificate', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('image')->nullable();
            $table->string('strCourseName')->nullable();
            $table->string('strIssueBy')->nullable();
            $table->string('strNumber')->nullable();
            $table->string('strIssueDate')->nullable();
            $table->string('strExpiryDate')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployeeCertificate');
    }
}
