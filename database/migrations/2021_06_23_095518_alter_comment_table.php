<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('comments', function (Blueprint $table) {
        //     $table->longText('content')->change();
        // });

        DB::statement('ALTER TABLE comments MODIFY content LONGTEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('comments', function (Blueprint $table) {
        //     $table->dropColumn('content');
        // });

        DB::statement('ALTER TABLE comments MODIFY content TEXT;');
    }
}
