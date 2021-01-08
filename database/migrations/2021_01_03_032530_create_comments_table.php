<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                //追加 user_idの作成
                $table->unsignedBigInteger('post_id');
                $table->text('comment');
                $table->timestamps();
                //追加　user_idに外部キー制約をつけますよ。usersテーブルのidカラムを参照してそのカラムがなくなったらカスケード的に処理します。
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            });
        } 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
