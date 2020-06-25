<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id');
            $table->bigInteger('product_id');
            $table->string('task');
            $table->string('relatedToLevel');
            $table->string('allocator');
            $table->string('type');
            $table->string('notified')->nullable();
            $table->timestamp('send_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->string('procedure')->nullable();
            $table->json('PHVA')->nullable();
            $table->string('frecuency')->nullable();
            $table->string('t_min')->nullable();
            $table->string('t_avg')->nullable();
            $table->string('t_max')->nullable();
            $table->string('quantity')->nullable();
            $table->string('laborType')->nullable();
            $table->string('competence')->nullable();
            $table->json('effort')->nullable();
            $table->json('risk')->nullable();
            $table->json('addedValue')->nullable();
            $table->json('correlation')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
