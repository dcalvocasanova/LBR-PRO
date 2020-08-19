<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file',500);
			$table->string('relatedToLevel');
            $table->string('input',100);
            $table->string('provider',100);
            $table->string('activity');
            $table->string('responsible');
			 $table->string('subprocessProduct');
			 $table->string('resultProduct');
            $table->string('user');
            $table->string('risk');
			$table->string('frecuency_risk');
			$table->string('consecuency_risk');
			$table->string('maturity_risk');
			$table->string('phva');
			 $table->string('subclassification');
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
        Schema::dropIfExists('processes');
    }
}
