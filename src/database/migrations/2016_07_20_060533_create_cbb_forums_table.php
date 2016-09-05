<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbbForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbb_forums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64)->unique();
            $table->text('description');
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('cbb_users')->onDelete('cascade');
            $table->boolean('disabled')->default(false);
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
        Schema::drop('cbb_forums');
    }
}
