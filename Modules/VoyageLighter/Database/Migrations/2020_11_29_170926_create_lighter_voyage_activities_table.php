<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLighterVoyageActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblLighterVoyageActivity', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageLighterId');
            $table->unsignedBigInteger('intLighterPositionStatusId');

            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->date('dteCompletionDate')->default(null);
            $table->string('strCompletionTime')->default(null);
            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->dateTime('dteCreatedAt')->default();

            $table->boolean('ysnStatus')->default(1);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblLighterVoyageActivity');
    }
}
