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
        // Lưu thông tin về tệp đính kèm (ảnh, video, tài liệu...).
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            // ID của tin nhắn chứa tệp
            $table->unsignedBigInteger('message_id');
            // URL của tệp
            $table->string('url', 255);
            // Loại tệp (image, video, document...)
            $table->string('type', 50);
            // Kích thước tệp (bytes)
            $table->unsignedBigInteger('size');
            // Thời điểm tải lên
            $table->timestamp('uploaded_at')->nullable();
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
