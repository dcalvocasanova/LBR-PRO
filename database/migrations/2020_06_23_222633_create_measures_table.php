<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('measures', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('project_id');
         $table->bigInteger('user_id');
         $table->bigInteger('task_id');
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
        Schema::dropIfExists('measures');
    }
}
