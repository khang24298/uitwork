<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_processes', function (Blueprint $table) {
            $table->string('process_name');
            $table->integer('process_id');
            $table->integer('status_id');

            $table->integer('next_status_id');
            $table->integer('prev_status_id');
            $table->integer('department_id');

            $table->primary(['process_id', 'status_id']);
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
        Schema::dropIfExists('work_processes');
    }
}
