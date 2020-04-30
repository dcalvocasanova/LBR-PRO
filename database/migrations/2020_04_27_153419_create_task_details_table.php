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
            $table->bigInteger('task_id');
            $table->string('procedure')->nullable;
            $table->json('PHVA')->nullable;
            $table->string('frecuency')->nullable;
            $table->string('t-min')->nullable;
            $table->string('t-avg')->nullable;
            $table->string('t-max')->nullable;
            $table->string('laborType')->nullable;
            $table->string('competence')->nullable;
            $table->string('effort')->nullable;
            $table->json('risk')->nullable;
            $table->json('addedValue')->nullable;
            $table->json('correlation')->nullable;
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
