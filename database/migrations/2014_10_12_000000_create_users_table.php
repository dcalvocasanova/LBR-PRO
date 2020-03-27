<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identification');
            $table->string('name',100);
            $table->string('salary',15);
            $table->date('birthday');
            $table->string('gender');
            $table->date('workingsince');
            $table->string('job');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('position');
            $table->string('education');
            $table->string('workday');
            $table->string('sex',20);
            $table->string('ethnic',20);
            $table->string('password');
            $table->string('type');
            $table->string('avatar');
            $table->bigInteger('relatedProjects');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
