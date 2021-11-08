<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEngOrConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_PSD')->create('tblEngineerVisit', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17)->index();
            $table->string('strActivityDate');
            $table->string('strAddress');
            $table->string('strMobileNumber');
            $table->string('strEngConsultantName');
            $table->unsignedInteger('intEngConsultantId');
            $table->unsignedInteger('intCoordinatedProject');
            $table->unsignedInteger('intOngoingProject');
            $table->string('strEmail');
            $table->string('strFarmInstOfficeName');
            $table->date('dteCreatedAt');
        
            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
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
        Schema::connection('DB_PSD')->dropIfExists('tblEngineerVisit');
    }
}
