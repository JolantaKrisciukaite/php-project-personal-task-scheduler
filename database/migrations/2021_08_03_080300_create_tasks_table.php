<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name', 128);
            $table->text('task_description');
            $table->unsignedBigInteger('statuse_id');
            $table->foreign('statuse_id')->references('id')->on('statuses');
            $table->timestamp('add_date')->nullable()->default(null);
            $table->timestamp('completed_date')->nullable()->default(null);
            $table->string('photo', 200)->nullable(); // nuotrauku idejimas
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
        Schema::dropIfExists('tasks');
    }
}
