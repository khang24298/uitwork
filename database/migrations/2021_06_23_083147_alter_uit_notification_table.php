<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterUitNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('uit_notifications', function (Blueprint $table) {
        //     $table->longText('content')->change();
        // });

        DB::statement('ALTER TABLE uit_notifications MODIFY content LONGTEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('uit_notifications', 'content')){
        //     Schema::table('uit_notifications', function (Blueprint $table) {
        //         $table->dropColumn('content');
        //     });
        // }

        DB::statement('ALTER TABLE uit_notifications MODIFY content TEXT;');
    }
}
