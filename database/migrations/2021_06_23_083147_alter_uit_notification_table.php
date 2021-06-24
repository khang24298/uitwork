<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUitNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uit_notifications', function (Blueprint $table) {
            //
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('uit_notifications', 'content')){
            Schema::table('uit_notifications', function (Blueprint $table) {
                $table->dropColumn('content');
            });
        }
    }
}
