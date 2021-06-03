<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('rankings', function (Blueprint $table) {
            $table->double('score_by_task_criteria')->after('user_id');
            $table->double('score_by_personnel_criteria')->after('score_by_task_criteria');
            $table->double('total_score')->after('score_by_personnel_criteria');
            // $table->renameColumn('rank_by_user_criteria_score', 'rank_by_personnel_criteria_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('rankings', function (Blueprint $table) {
            $table->dropColumn('score_by_task_criteria');
            $table->dropColumn('score_by_personnel_criteria');
            $table->dropColumn('total_score');
            // $table->renameColumn('rank_by_personnel_criteria_score', 'rank_by_user_criteria_score');
        });
    }
}
