<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('introduction')->nullable();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('category_id_one')->unsigned()->index();
            $table->integer('category_id_second')->unsigned()->index();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('url')->nullable();
            $table->string('cover')->nullable();
            $table->string('cover_s')->nullable();
            $table->string('video_duration')->nullable();
            $table->timestamp('time')->nullable();
            $table->integer('watch_jurisdiction')->unsigned()->default(0);
            $table->integer('transfer')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('videos');
    }
}
