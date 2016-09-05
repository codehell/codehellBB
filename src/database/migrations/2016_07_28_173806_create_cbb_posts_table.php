<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbbPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbb_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 128);
            $table->text('content');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('cbb_users')->onDelete('cascade');
            $table->integer('forum_id')->unsigned();
            $table->foreign('forum_id')->references('id')->on('cbb_forums')->onDelete('cascade');
            $table->boolean('disabled');
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
        Schema::drop('cbb_posts');
    }
}
