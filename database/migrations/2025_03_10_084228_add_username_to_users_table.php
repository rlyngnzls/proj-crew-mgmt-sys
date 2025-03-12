<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 10)->unique()->after('id'); // Add username
            $table->string('crew_id', 10)->unique()->after('id'); // Add crew_id
            $table->string('user_type', 255)->after('password'); // Add user_type
            $table->softDeletes()->after('updated_at'); // Add deleted_at
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
            $table->dropColumn('username');
            $table->dropColumn('crew_id');
            $table->dropColumn('user_type');
            $table->dropColumn('deleted_at');
            
        });
    }
}
