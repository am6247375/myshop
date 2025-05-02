<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCurrencyFieldInStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            // حذف الحقل القديم
            $table->dropColumn('currency');

            // إضافة الحقل الجديد كمفتاح خارجي
            $table->unsignedBigInteger('currency_id')->nullable()->after('id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            // حذف المفتاح الخارجي والحقل
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');

            // إعادة الحقل القديم
            $table->string('currency', 10)->nullable();
        });
    }
}
