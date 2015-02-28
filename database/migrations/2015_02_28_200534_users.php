<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Users extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $collection) {
            $collection->index('slack_id');
            $collection->index('team_id');
        });
    }

    public function down()
    {
        Schema::drop('users');
    }

}
