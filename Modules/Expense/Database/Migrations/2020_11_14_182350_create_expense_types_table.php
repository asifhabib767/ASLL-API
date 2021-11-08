<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblExpenseType', function (Blueprint $table) {
            $table->bigIncrements('intExpenseTypeId');
            $table->unsignedBigInteger('intExpenseCategoryId')->nullable();
            $table->string('strExpenseTypeName');
            $table->string('strExpenseTypeCode');
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
        Schema::connection('ERP_Apps')->dropIfExists('tblExpenseType');
    }
}
