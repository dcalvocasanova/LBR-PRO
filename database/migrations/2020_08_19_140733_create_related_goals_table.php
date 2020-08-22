<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('related_goals', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('project_id');
         $table->String('relatedLevel');
         $table->String('parentGoal');
		 $table->String('currentGoals');
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
        Schema::dropIfExists('related_goals');
    }
}
