<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('active')->default(1);
            $table->string('logo', 255);
            $table->string('currency', 10);
            $table->string('whatsapp_link', 255)->nullable();
            $table->string('facebook_link', 255)->nullable();
            $table->string('instagram_link', 255)->nullable();
            $table->string('about')->nullable();
            $table->foreignId('template_id')->constrained('templates')->onDelete('cascade'); 
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
