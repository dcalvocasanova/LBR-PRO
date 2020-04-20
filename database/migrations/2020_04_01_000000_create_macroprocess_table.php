<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMacroprocessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macroprocesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('macroprocess');
            $table->string('input',100);
            $table->string('provider',15);
            $table->string('activity');
            $table->string('responsible');
            $table->string('process');
            $table->string('user');
            $table->string('risk');
            $table->string('indicator');
			      $table->string('project_id');
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
        Schema::dropIfExists('Macroprocesses');
    }
}
