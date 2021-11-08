<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_HR')->create('tblEmployeeTracking', function (Blueprint $table) {
            $table->bigIncrements('intAutoID');
            $table->unsignedBigInteger('intUnitId');
            $table->unsignedBigInteger('intEmployeeID');
            $table->unsignedBigInteger('intEmployeeTypeID')->nullable();
            $table->dateTime('dteDate')->nullable();

            $table->dateTime('dtePunchInTime')->nullable()->index();
            $table->dateTime('dtePunchOutTime')->nullable()->index();
            $table->string('decLatitude')->nullable()->index();

            $table->string('decLongitude')->default(false);
            $table->string('strLocation')->default(false);


            $table->boolean('ysnEnable')->default(true);

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
        Schema::connection('ERP_HR')->dropIfExists('tblEmployeeTracking');
    }
}
