<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionDeductionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblAdditionDeductionDetails', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intAdditionDeductionId');
            $table->integer('intAdditionDeductionTypeId')->nullable();
            $table->string('strAdditionDeductionTypeName')->nullable();
            $table->float('amount')->nullable();
            $table->integer('intEmployeeId')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblAdditionDeductionDetails');
    }
}
