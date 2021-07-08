<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('tasks', function (Blueprint $table) {
        //     $table->longText('description')->change();
        // });

        DB::statement('ALTER TABLE tasks MODIFY description LONGTEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('tasks', 'description')){
        //     Schema::table('tasks', function (Blueprint $table) {
        //         $table->dropColumn('description');
        //     });
        // }

        DB::statement('ALTER TABLE tasks MODIFY description TEXT;');
    }
}
