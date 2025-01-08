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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            // Danh sách ID của người tham gia cuộc trò chuyện
            $table->json('participants');
            // Nội dung tin nhắn cuối cùng
            $table->text('last_message')->nullable();
            // Thời gian tin nhắn cuối được gửi
            $table->timestamp('last_time')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
