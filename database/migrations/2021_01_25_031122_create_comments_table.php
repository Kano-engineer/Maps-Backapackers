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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->foreignId('user_id')->nullable();;
            $table->foreignId('pin_id')->nullable();;
            $table->foreignId('profile_id')->nullable();;
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
        Schema::dropIfExists('comments');
    }

    public function isFollowing($user_id)
   {
       // exists()でテーブルにレコードが存在しているかをチェック
       return $this->follows()->where('followed_id', $user_id)->exists();
   }

   public function isFollowed($user_id)
   {
       return $this->followers()->where('following_id', $user_id)->exists();
   }
   
}
