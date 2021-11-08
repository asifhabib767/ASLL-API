<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLighterUnloadCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblLighterUnloadCategory', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->string('strCategoryName');
          
            $table->tinyInteger('ysnActive');
            $table->integer('intCreatedBy');
            $table->date('dteCreatedAt');
          
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
        Schema::connection('DB_ASLL')->dropIfExists('tblLighterUnloadCategory');
    }
}
