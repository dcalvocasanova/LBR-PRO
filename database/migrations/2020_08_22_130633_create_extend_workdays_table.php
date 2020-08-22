<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendWorkdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('extend_workdays', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('project_id');
		 $table->bigInteger('user');
		 $table->String('relatedToLevel');
         $table->String('extend');
		   $table->date('fecha');
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
        Schema::dropIfExists('extend_workdays');
    }
}
