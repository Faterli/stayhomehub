<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id')->comment('vid');;
            $table->string('title')->index()->comment('标题');;
            $table->string('introduction')->nullable()->comment('介绍');;
            $table->bigInteger('user_id')->unsigned()->index()->comment('上传者id');;
            $table->integer('category_id')->unsigned()->index()->comment('一级分类');;
            $table->integer('category_id_second')->unsigned()->index()->comment('二级分类');;
            $table->string('country')->nullable()->comment('国家');;
            $table->string('province')->nullable()->comment('省份');;
            $table->string('city')->nullable()->comment('城市');;
            $table->string('source_url')->nullable()->comment('视频url');;
            $table->string('cover')->nullable()->comment('焦点竖图');;
            $table->string('cover_s')->nullable()->comment('焦点横图');;
            $table->string('video_duration')->nullable()->comment('视频时长');;
            $table->timestamp('time')->nullable()->comment('拍摄时间');;
            $table->integer('user_watch_jurisdiction')->unsigned()->default(0)->comment('私密视频');;
            $table->integer('transfer')->unsigned()->default(0)->comment('可转载');;
            $table->integer('is_delete')->unsigned()->default(0)->comment('删除');;
            $table->integer('status')->unsigned()->default(0)->comment('审核状态');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('videos');
    }
}
