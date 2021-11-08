<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblCodeCount', function (Blueprint $table) {
            $table->bigIncrements('intLighterId');
            $table->date('year');
            $table->unsignedBigInteger('intCount');
            $table->string('strCodeFor');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblCodeCount');
    }
}
