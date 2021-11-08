<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintForwardedTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_PSD')->create('tblComplainForwardType', function (Blueprint $table) {
            $table->bigIncrements('intForwardedTypeId');
            $table->unsignedInteger('strForwardedTypeName');
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
        Schema::connection('DB_PSD')->dropIfExists('tblComplainForwardType');
    }
}
