<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskImprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_improves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id');
            $table->string('task_id');
            $table->string('competence')->nullable;
            $table->json('effort')->nullable;
            $table->json('risk')->nullable;
            $table->json('addedValue')->nullable;
            $table->json('correlation')->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_improves');
    }
}
