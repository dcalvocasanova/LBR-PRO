<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertings', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('project_id');
          $table->string('title');
          $table->string('body');
          $table->string('sender');
          $table->string('type');
          $table->string('status');
          $table->string('receiver');
          $table->string('reasons');
          $table->string('relatedToLevel');
          $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('alertings');
    }
}
