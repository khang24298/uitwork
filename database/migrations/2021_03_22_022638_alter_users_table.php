<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email_verified_at')->nullable();
            $table->string('gender')->after('phone')->nullable();
            $table->string('dob')->after('gender')->nullable();
            $table->integer('position_id')->after('dob')->nullable();
            $table->integer('education_level_id')->after('position_id')->nullable();
            $table->integer('department_id')->after('education_level_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('gender');
            $table->dropColumn('dob');
            $table->dropColumn('position_id');
            $table->dropColumn('education_level_id');
            $table->dropColumn('department_id');
        });
    }
}
