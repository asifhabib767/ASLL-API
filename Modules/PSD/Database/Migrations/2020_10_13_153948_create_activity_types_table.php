<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_PSD')->create('tblActivityType', function (Blueprint $table) {
            $table->bigIncrements('intActivityTypeId');
            $table->string('strActivityTypeName');
            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->date('dteCreatedAt');

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
        Schema::connection('DB_PSD')->dropIfExists('tblActivityType');
    }
}
