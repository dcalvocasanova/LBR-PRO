<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id');
            $table->string('task_id');
            $table->string('procedure')->nullable;
            $table->json('PHVA')->nullable;
            $table->string('frecuency')->nullable;
            $table->string('t_min')->nullable;
            $table->string('t_avg')->nullable;
            $table->string('t_max')->nullable;
            $table->string('laborType')->nullable;
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
        Schema::dropIfExists('task_details');
    }
}
