<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_PSD')->create('tblSiteVisit', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intUnitId')->default(17)->index();
            $table->string('strActivityDate');
            $table->string('strOwnerName');
            $table->string('strAddress');
            $table->string('strMobileNumber');
            $table->string('strConstructionTypeName')->nullable();
            $table->unsignedInteger('intConstructionTypeId');
            $table->string('strFeedbackTypeName')->nullable();
            $table->unsignedInteger('intFeedbackTypeId');
            $table->unsignedInteger('intActivityTypeId');
            $table->string('strActivityTypeName');
            $table->float('decStepsRecomended')->default(0)->nullable();
            $table->float('decApproxConsumption')->default(0)->nullable();
            $table->string('strNextFollowUpdate');
            $table->date('dteCreatedAt');
            
            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intApprovedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
            $table->unsignedBigInteger('intDeletedBy')->nullable()->index();
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
        Schema::connection('DB_PSD')->dropIfExists('tblSiteVisit');
    }
}
