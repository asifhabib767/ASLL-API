<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblTransactionType', function (Blueprint $table) {
            $table->bigIncrements('intTransactionTypeId');
            $table->unsignedBigInteger('intExpenseTypeId')->nullable();
            $table->string('strTransactionTypeName');
            $table->string('strTransactionTypeCode');
            $table->unsignedBigInteger('intBusinessId')->nullable();
            $table->boolean('ysnActive')->default(true);
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
        Schema::connection('ERP_Apps')->dropIfExists('tblTransactionType');
    }
}
