<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblExpenseReference', function (Blueprint $table) {
            $table->bigIncrements('intExpenseReferenceId');
            $table->unsignedBigInteger('intExpenseTypeId')->nullable();
            $table->string('strExpenseReferenceName');
            $table->string('strExpenseReferenceCode');
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
        Schema::connection('ERP_Apps')->dropIfExists('tblExpenseReference');
    }
}
