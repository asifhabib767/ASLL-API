<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // strBillDate ,decStartime ,decEndtime , decMovDuration,strPurpouse,purpid ,intSl,tmStart,tmEnd,tmDifference
        // ,Applicantenrol ,dteInsertionDate ,intEnroll

        Schema::connection('ERP_SAD')->create('tblShippingPoint', function (Blueprint $table) {
            $table->bigIncrements('intId');
            $table->unsignedBigInteger('intUnitId');

            $table->string('strName')->nullable()->index();
            $table->string('strDescription')->nullable()->index();
            $table->boolean('ysnEnable')->nullable()->index();

            $table->unsignedBigInteger('intInsertedBy')->nullable()->index();
            $table->dateTime('dteInsertionTime')->nullable()->index();
            $table->unsignedBigInteger('intLastModifiedBy')->nullable()->index();

            $table->dateTime('dteLastModificationTime')->nullable()->index();
            $table->string('strPrefix')->nullable()->index();
            $table->string('strCodeFor')->nullable()->index();
            $table->string('strAddress')->nullable()->index();

            $table->boolean('ysnWareHouseOnly')->nullable()->index();
            $table->unsignedBigInteger('intLogisticCatagory')->nullable()->index();
            $table->string('strContactPerson')->nullable()->index();
            $table->string('strContactNo')->nullable()->index();




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
        Schema::connection('ERP_SAD')->dropIfExists('tblShippingPoint');
    }
}
