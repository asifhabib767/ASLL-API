<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCurrencyConversion', function (Blueprint $table) {
            $table->id('intID');
            $table->unsignedBigInteger('intConvertedFromId');
            $table->unsignedBigInteger('intConvertedToId');
            $table->float('decUSDAmount');
            $table->float('decBDTAmount');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblCurrencyConversion');
    }
}
