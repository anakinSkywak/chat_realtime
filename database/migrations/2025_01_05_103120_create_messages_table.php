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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // ID của cuộc trò chuyện
            $table->unsignedBigInteger('conversation_id');
            // ID của người gửi
            $table->unsignedBigInteger('user_id');
            // Nội dung tin nhắn
            $table->text('content');
            // Trạng thái tin nhắn (đã gửi, đã nhận, đã xem)
            $table->enum('status', ['đã gửi', 'đã nhận', 'đã xem'])->default('đã gửi');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Thời gian gửi
            $table->timestamp('sent_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
