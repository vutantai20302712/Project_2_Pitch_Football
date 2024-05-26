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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên khách hàng có thể là kiểu string
            $table->string('email'); // Email cũng có thể là kiểu string
            $table->string('password'); // Thay đổi tên cột pass thành password, và sử dụng kiểu dữ liệu chuỗi
            $table->string('phone_number'); // Số điện thoại cũng có thể là kiểu string
            $table->timestamps(); // Thêm cột created_at và updated_at để ghi lại thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
