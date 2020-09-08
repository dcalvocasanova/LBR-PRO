<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('settings_measures', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->bigInteger('project_id');
         $table->String('vacation');
    		 $table->String('license');
    		 $table->String('training');
    		 $table->String('yeardays');
    		 $table->String('weekdays');
    		 $table->String('workdays');
    		 $table->date('startProject');
    		 $table->date('endProject');
         $table->String('disability');
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
        Schema::dropIfExists('settings_measures');
    }
}
