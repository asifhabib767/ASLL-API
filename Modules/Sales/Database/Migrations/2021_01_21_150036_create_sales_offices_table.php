<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // intId,intUnitId ,intParentId ,strName,strDescription ,ysnEnable,intInsertedBy
        // ,dteInsertionTime,intLastModifiedBy,dteLastModificationTime,strPrefix  ,strCodeFor ,ysnPendingDORemove,ysnSMSEnable,intCategoryid
        // ,strReturnDOPrefix ,ysnDiscountApply,strQuationPrefix ,strQuationCodeFor ,ysnBalanceChkInOrder ,ysnDOCompleteAuto

        Schema::connection('ERP_SAD')->create('tblSalesOffice', function (Blueprint $table) {
            $table->bigIncrements('intId');
            $table->unsignedBigInteger('intUnitId');

            $table->unsignedBigInteger('intParentId')->nullable()->index();
            $table->string('strName')->nullable()->index();
            $table->string('strDescription')->nullable()->index();

            $table->boolean('ysnEnable')->nullable()->index();
            $table->unsignedBigInteger('intInsertedBy')->nullable()->index();
            $table->dateTime('dteInsertionTime')->nullable()->index();

            $table->unsignedBigInteger('intLastModifiedBy')->nullable()->index();
            $table->dateTime('dteLastModificationTime')->nullable()->index();
            $table->string('strPrefix')->nullable()->index();
            $table->string('strCodeFor')->nullable()->index();

            $table->boolean('ysnPendingDORemove')->nullable()->index();
            $table->boolean('ysnSMSEnable')->nullable()->index();
            $table->unsignedBigInteger('intCategoryid')->nullable()->index();
            $table->string('strReturnDOPrefix')->nullable()->index();


            $table->boolean('ysnDiscountApply')->nullable()->index();
            $table->string('strQuationPrefix')->nullable()->index();
            $table->string('strQuationCodeFor')->nullable()->index();
            $table->boolean('ysnBalanceChkInOrder')->nullable()->index();

            $table->boolean('ysnDOCompleteAuto')->nullable()->index();






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
        Schema::connection('ERP_SAD')->dropIfExists('tblSalesOffice');
    }
}
