<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('project_id');
            $table->bigInteger('user_id');
			$table->bigInteger('category_id');
			$table->string('variable');
			$table->date('fecha');
            $table->string('measure')->nullable();
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
        Schema::dropIfExists('parameters_measures');
    }
}
