<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblUnloadNStandByQntsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblUnloadNStandByQntMain', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->date('dteDate');
            $table->date('dteInsertDate');
            $table->integer('intTypeID');
            $table->string('strTypeName');
            $table->float('GrandTotal');
            $table->integer('intInsertBy');
            $table->boolean('ysnActive')->default(1);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblUnloadNStandByQntMain');
    }
}
