<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // رقم الطلب
            $table->unsignedBigInteger('store_id'); // رقم المتجر
            $table->unsignedBigInteger('user_id')->nullable(); // رقم البائع
            $table->unsignedBigInteger('customer_id'); // رقم المشتري
            $table->string('recipient_name'); // اسم المستلم
            $table->string('recipient_phone'); // هاتف المستلم
            $table->text('recipient_address'); // عنوان المستلم
            $table->text('note')->nullable(); // ملاحظات إضافية
            $table->string('status')->default('pending'); // حالة الطلب
            $table->decimal('total_price', 10, 2); // السعر الكلي للطلب
            $table->timestamps(); // created_at, updated_at

            // المفاتيح الخارجية
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
