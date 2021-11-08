<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_CRM')->create('tblContactGroup', function (Blueprint $table) {
            $table->unsignedBigInteger('intContactGroupId');
            $table->string('strContactGroupName');
            $table->boolean('ysnActive')->default(true);
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
        Schema::connection('DB_CRM')->dropIfExists('tblContactGroup');
    }
}
