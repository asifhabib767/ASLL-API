<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelLogMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblFuelLogMain', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intLighterId');
            $table->string('strLighterName')->nullable();
            $table->date('dteDate');
            $table->text('strDetails')->nullable();

            $table->unsignedBigInteger('intVoyageId')->nullable();
            $table->unsignedBigInteger('intVoyageNo')->nullable();
            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intDeletedBy')->nullable();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();
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
        Schema::connection('DB_ASLL')->dropIfExists('tblFuelLogMain');
    }
}
