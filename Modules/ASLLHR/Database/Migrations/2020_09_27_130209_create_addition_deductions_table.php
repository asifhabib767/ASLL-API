<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblAdditionDeduction', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intEmployeeId')->nullable();
            $table->float('decTotal')->nullable();
            $table->unsignedBigInteger('currencyId')->nullable();
            $table->string('strCurrencyName')->nullable();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblAdditionDeduction');
    }
}
