<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageActivityBoilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageActivityBoiler', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageActivityID');
            $table->unsignedBigInteger('intVoyageActivityBoilerMainID');

            $table->float('decWorkingPressure')->default(0)->nullable();
            $table->dateTime('dteCreatedAt')->nullable();
            $table->float('decPhValue')->default(0)->nullable();
            $table->float('decChloride')->default(0)->nullable();
            $table->float('decAlkalinity')->default(0)->nullable();

            $table->unsignedBigInteger('intCreatedBy')->nullable()->index();
            $table->unsignedBigInteger('intApprovedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();
            $table->unsignedBigInteger('intDeletedBy')->nullable()->index();

            $table->boolean('ysnActive')->default(1);
            $table->softDeletes();

            $table->foreign('intVoyageActivityID')->references('intID')->on('tblVoyageACtivity');
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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageActivityBoiler');
    }
}
