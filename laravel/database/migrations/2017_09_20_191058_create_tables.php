<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DO NOT CHANGE TABLE NAME
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar');
            $table->string('name');
            $table->string('wechat_number');
            $table->unsignedInteger('point')->default(0);
            $table->tinyInteger('status')->default(0)->comment('用户状态 0正常 1冻结');
            // $table->string('password');
            $table->string('api_token', 64);
            $table->string('session_token', 64);
            // ADD MORE FIELDS
            // $table->rememberToken();
            $table->timestamps();
            $table->unique('wechat_number');
            $table->unique('api_token');
        });

        // DO NOT CHANGE TABLE NAME
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account', 64);
            $table->string('password');
            // ADD MORE FIELDS
            $table->rememberToken();
            $table->timestamps();
            $table->unique('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('admins');
    }
}
