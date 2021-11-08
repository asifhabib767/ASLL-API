<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbltblUnloadNStandByQntDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblUnloadNStandByQntDetails', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intUnloadNStandByQntPKId');
          
            $table->integer('intItemID');
            $table->string('strItemName');
            $table->float('decQnt');
          
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
        Schema::connection('DB_ASLL')->dropIfExists('tblUnloadNStandByQntDetails');
    }
}
