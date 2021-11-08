<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_CRM')->create('tblDocument', function (Blueprint $table) {
            $table->bigIncrements('intDocumentId');
            $table->string('strFileName');
            $table->enum('strFileType', ['image', 'video', 'pdf', 'doc', 'music'])
            ->default('image')
            ->nullable();
            $table->string('strFilePublicURL')->nullable();
            $table->string('strFileFullName')->nullable();
            $table->text('strDocumentDescription')->nullable();
            $table->boolean('ysnActive')->default(true);
            $table->unsignedBigInteger('intTotalUsed')->default(0);

            $table->unsignedBigInteger('intCreatedBy')->nullable();
            $table->unsignedBigInteger('intCreatedUserTypeId')->nullable();
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
        Schema::connection('DB_CRM')->dropIfExists('tblDocument');
    }
}
