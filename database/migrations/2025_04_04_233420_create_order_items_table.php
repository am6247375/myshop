<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // رقم العنصر (مفتاح أساسي)
            $table->unsignedBigInteger('order_id'); // رقم الطلب (FK)
            $table->unsignedBigInteger('product_id'); // رقم المنتج (FK)
            $table->integer('quantity'); // الكمية المطلوبة
            $table->decimal('price', 10, 2); // سعر المنتج في هذا الطلب
            $table->decimal('total_price', 10, 2); // المجموع الكلي (الكمية * السعر)
            $table->timestamps(); // created_at, updated_at

            // المفاتيح الخارجية
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
}
