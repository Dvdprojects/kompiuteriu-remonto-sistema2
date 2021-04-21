<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForumCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('forums_id');
            $table->string('forum_post_comment');
            $table->timestamps();
        });
        Schema::table('forum_comments', function (Blueprint $table) {
            $table->foreign('user_id', 'forum_comments_to_user')->references('id')->on('users');
            $table->foreign('forums_id', 'comments_to_forum_post')->references('id')->on('forums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_comments');
    }
}
