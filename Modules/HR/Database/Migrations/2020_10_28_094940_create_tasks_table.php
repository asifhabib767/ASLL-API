<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('ERP_Apps')->create('tblTasks', function (Blueprint $table) {
            $table->bigIncrements('intTaskId');
            $table->unsignedBigInteger('intUnitId');
            $table->string('strTaskTitle');
            $table->text('strTaskDetails')->nullable();
            $table->text('strTaskUpdateDetails')->nullable();

            $table->unsignedBigInteger('intAssignedTo')->nullable()->index();
            $table->unsignedBigInteger('intAssignedBy')->nullable()->index();
            $table->unsignedBigInteger('intUpdatedBy')->nullable()->index();

            $table->boolean('ysnSeenByAssignedTo')->default(false);
            $table->boolean('ysnUpdateSeenByAssignedBy')->default(false);

            $table->date('dteCreatedAt');
            $table->dateTime('dteTaskStartDateTime')->nullable();
            $table->dateTime('dteTaskEndDateTime')->nullable();

            $table->boolean('ysnOwnAssigned')->default(false);
            $table->enum('status', ['pending', 'done', 'reject'])->default('pending');
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
        Schema::connection('ERP_Apps')->dropIfExists('tblTasks');
    }
}
