<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblExpenseRegisterRow', function (Blueprint $table) {
            $table->bigIncrements('intExpenseRowId');
            $table->unsignedBigInteger('intExpenseId')->comment('Expense Header ID');
            $table->string('strExpenseCode');
            $table->date('dteExpenseDate');

            $table->unsignedBigInteger('intExpenseCategoryId')->nullable();
            $table->string('strExpenseCategoryName')->nullable();

            $table->unsignedBigInteger('intExpenseTypeId')->nullable();
            $table->string('strExpenseTypeName')->nullable();

            $table->unsignedBigInteger('intExpenseReferenceId')->nullable();
            $table->string('strExpenseReferenceName')->nullable();
            $table->integer('intReferenceId')->nullable();
            $table->string('strReferenceNo')->nullable();

            $table->unsignedBigInteger('intTransactionTypeId')->nullable();
            $table->string('strTransactionTypeName')->nullable();

            $table->string('strComments')->nullable();
            $table->float('numQuantity')->default(0);
            $table->float('numRate')->default(0);
            $table->float('numAmount')->default(0);
            $table->string('strExpenseLocation')->nullable();

            $table->string('strAttachmentLink')->nullable();

            $table->boolean('ysnComplete')->default(true);
            $table->boolean('ysnActive')->default(true);

            $table->unsignedBigInteger('intActionBy')->nullable();
            $table->dateTime('dteLastActionDateTime')->nullable();
            $table->dateTime('dteServerDateTime')->nullable();

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
        Schema::connection('ERP_Apps')->dropIfExists('tblExpenseRegisterRow');
    }
}
