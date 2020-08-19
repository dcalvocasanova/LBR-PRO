<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubprocessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprocesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('input',100);
			$table->string('relatedToLevel');
            $table->string('provider',100);
            $table->string('activity');
            $table->string('responsible');
			$table->string('product');
			$table->string('process');
            $table->string('user');
            $table->string('risk');
			$table->string('frecuency_risk');
			$table->string('consecuency_risk');
			$table->string('maturity_risk');
			$table->string('phva');
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
        Schema::dropIfExists('subprocesses');
    }
}
