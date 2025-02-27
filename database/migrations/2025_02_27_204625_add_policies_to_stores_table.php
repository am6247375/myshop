<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            // إضافة عمود "سياسة الخصوصية"، يمكن أن يكون فارغاً، ويأتي بعد عمود "about"
            $table->text('privacy_policy')->nullable()->after('about');
    
            // إضافة عمود "الشروط والأحكام"، يمكن أن يكون فارغاً، ويأتي بعد عمود "privacy_policy"
            $table->text('terms_and_conditions')->nullable()->after('privacy_policy');
    
            // إضافة عمود "سياسة الاسترجاع والاسترداد"، يمكن أن يكون فارغاً، ويأتي بعد عمود "terms_and_conditions"
            $table->text('return__policy')->nullable()->after('terms_and_conditions');
            });
    }
    
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            // إزالة الأعمدة المضافة إذا تم التراجع عن الترحيل
            $table->dropColumn([
                'privacy_policy', // إزالة عمود "سياسة الخصوصية"
                'terms_and_conditions', // إزالة عمود "الشروط والأحكام"
                'return_and_policy', // إزالة عمود "سياسة الاسترجاع والاسترداد"
            ]);
        });
    }
    
};
