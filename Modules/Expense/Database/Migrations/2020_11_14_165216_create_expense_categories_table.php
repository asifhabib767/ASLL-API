<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblExpenseCategory', function (Blueprint $table) {
            $table->bigIncrements('intExpenseCategoryId');
            $table->string('strExpenseCategoryName');
            $table->string('strExpenseCategoryCode');
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
        Schema::connection('ERP_Apps')->dropIfExists('tblExpenseCategory');
    }
}
