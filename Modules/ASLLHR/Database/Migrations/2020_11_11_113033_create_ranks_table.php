<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblRank', function (Blueprint $table) {
            $table->id('intID');
            $table->string('strRankName')->unique();
            $table->string('strRankSlug')->unique();
            $table->boolean('ysnActive')->default(true);
            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedInteger('priority')->default(100);
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
        Schema::connection('DB_ASLL')->dropIfExists('tblRank');
    }
}
