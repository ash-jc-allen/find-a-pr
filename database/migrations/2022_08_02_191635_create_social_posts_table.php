<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->string('issue_repo');
            $table->integer('issue_number')->unsigned();
            $table->bigInteger('issue_id')->unsigned();
            $table->bigInteger('tweet_id')->nullable();
            $table->timestamp('twitter_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
