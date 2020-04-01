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
            $table->string('input',100);
            $table->string('provider',100);
            $table->string('activity');
            $table->string('responsible');
			 $table->string('subprocessProduct');
			 $table->string('resultProduct');
            $table->string('user');
            $table->string('risk');
			$table->string('phva');
			 $table->string('subclassification');
            $table->string('indicator');
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
