<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedAdminsData extends Migration
{
    public function up()
    {
        $admins = [
            [
                'name'       => '站长',
                'phone'      => '18000000000',
                'email'      => '123@123.com',
                'password'   => '$2y$10$JlDd.M5UHM9uSgp905yxXuOwuAGtLqumxItzlFzgiXC8M4cQ7N39a',
                'status'     => '1',
                'admin_type' => '1',
            ],
        ];
        DB::table('admins')->insert($admins); }
    public function down()
    {
        DB::table('admins')->truncate(); }
}
