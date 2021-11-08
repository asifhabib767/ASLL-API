<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_CRM')->create('tblContact', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->integer('intGroupId')->nullable();
            $table->string('strGroupName')->nullable();
            $table->string('strCustomerName')->nullable();
            $table->string('strOrganizationName')->nullable();
            $table->string('strDesignation')->nullable();
            $table->string('strContactNo')->nullable();
            $table->string('strEmail')->nullable();
            $table->string('strLatitude')->nullable();
            $table->string('strLongitude')->nullable();

            $table->unsignedBigInteger('intCreatedBy');
            $table->unsignedBigInteger('intCreatedAtUserTypeId');

            $table->unsignedBigInteger('intUpdatedBy')->nullable();
            $table->unsignedBigInteger('intUpdatedAtUserTypeId')->nullable();
            
            $table->boolean('ysnActive')->default(true);

            $table->unsignedBigInteger('intDeletedBy')->nullable();
            $table->unsignedBigInteger('intDeletedAtUserTypeId')->nullable();
            $table->string('image')->nullable();
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
        Schema::connection('DB_CRM')->dropIfExists('tblContact');
    }
}
