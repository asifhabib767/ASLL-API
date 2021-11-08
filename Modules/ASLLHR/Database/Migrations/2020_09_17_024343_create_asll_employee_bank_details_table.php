<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsllEmployeeBankDetailsTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLEmployeeBankDetails', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('image')->nullable();
            $table->string('strAccountHolderName')->nullable();
            $table->string('strAccountNumber')->nullable();
            $table->string('strBankName')->nullable();
            $table->string('strBankAddress')->nullable();
            $table->string('strSwiftCode')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLEmployeeBankDetails');
    }
}
