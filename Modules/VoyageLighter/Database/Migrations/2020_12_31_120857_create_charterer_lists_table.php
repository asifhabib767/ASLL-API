<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartererListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblASLLChartererList', function (Blueprint $table) {
            $table->bigIncrements('intChartererId');
            $table->string('strChartererName');
            $table->string('strChartererAddress');
            $table->string('strEmail');
            $table->string('strContactNo');

            $table->string('strContactPerson');
            $table->boolean('isActive');
         
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
        Schema::connection('DB_ASLL')->dropIfExists('tblASLLChartererList');
    }
}
