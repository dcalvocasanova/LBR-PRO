<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id');
            $table->string('relatedToLevel');
			$table->string('relatedTemplate');
			$table->string('relatedUsers');    
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
        Schema::dropIfExists('TemplateUsers');
    }
}
