<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('用户id');;
            $table->string('name')->comment('名字');;
            $table->string('phone')->unique()->comment('手机号');;
            $table->string('email')->unique()->comment('邮箱');;
            $table->string('password')->comment('密码');;
            $table->string('avatar')->comment('头像');;
            $table->integer('gender')->comment('性别');;
            $table->bigInteger('birthday')->comment('生日');;
            $table->rememberToken();
            $table->integer('notification_count')->unsigned()->default(0)->comment('未读通知');
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
        Schema::dropIfExists('users');
    }
}
