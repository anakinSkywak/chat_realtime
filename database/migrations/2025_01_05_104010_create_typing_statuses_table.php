<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('typing_statuses', function (Blueprint $table) {
            $table->id();
            // ID của cuộc trò chuyện
            $table->unsignedBigInteger('conversation_id');
            // ID của người dùng
            $table->unsignedBigInteger('user_id');
            // Trạng thái đang gõ (true/false)
            $table->boolean('typing')->default(false);
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_statuses');
    }
};
