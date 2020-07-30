<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',80);
            $table->string('logo_project',80);
            $table->string('logo_sponsor',80);
            $table->string('logo_auxiliar',80);
            $table->string('latitude',200);
            $table->string('longitude',20);
            $table->string('economic_activity',100);
            $table->string('terms_connditions',100);
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
        Schema::dropIfExists('projects');
    }
}
