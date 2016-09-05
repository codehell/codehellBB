<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbbCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbb_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('cbb_users')->onDelete('cascade');
            $table->integer('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('id')->on('cbb_posts')->onDelete('cascade');
            $table->integer('parent')->unsigned()->nullable();
            $table->foreign('parent')->references('id')->on('cbb_comments')->onDelete('cascade');
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
        Schema::drop('cbb_comments');
    }
}
