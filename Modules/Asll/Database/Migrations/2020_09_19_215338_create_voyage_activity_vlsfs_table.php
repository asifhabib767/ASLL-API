<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoyageActivityVlsfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('DB_ASLL')->create('tblVoyageActivityVlsf', function (Blueprint $table) {
            $table->bigIncrements('intID');
            $table->unsignedBigInteger('intVoyageActivityID');

            $table->float('decBunkerVlsfoCon')->default(0)->nullable();
            $table->float('decBunkerVlsfoAdj')->default(0)->nullable();
            $table->float('decBunkerVlsfoRob')->default(0)->nullable();

            $table->float('decBunkerLsmgoCon')->default(0)->nullable();
            $table->float('decBunkerLsmgoAdj')->default(0)->nullable();
            $table->float('decBunkerLsmgoRob')->default(0)->nullable();

            $table->float('decLubMeccCon')->default(0)->nullable();
            $table->float('decLubMeccAdj')->default(0)->nullable();
            $table->float('decLubMeccRob')->default(0)->nullable();

            $table->float('decLubMecylCon')->default(0)->nullable();
            $table->float('decLubMecylAdj')->default(0)->nullable();
            $table->float('decLubMecylRob')->default(0)->nullable();

            $table->float('decLubAeccCon')->default(0)->nullable();
            $table->float('decLubAeccAdj')->default(0)->nullable();
            $table->float('decLubAeccRob')->default(0)->nullable();
            $table->string('strRemarks');

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
        Schema::connection('DB_ASLL')->dropIfExists('tblVoyageActivityVlsf');
    }
}
