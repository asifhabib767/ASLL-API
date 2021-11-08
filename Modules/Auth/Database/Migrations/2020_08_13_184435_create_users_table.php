<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblLoginUser', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('intEnroll')->nullable();
            $table->unsignedBigInteger('business_id')
                ->nullable()
                ->comment('It will be null if user is totally new');
            $table->string('first_name');
            $table->string('surname')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('password');
            $table->char('language', 4)->default('en');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->index('business_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('ERP_Apps')->dropIfExists('tblLoginUser');
    }
}
