<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_tm');
            $table->string('name_ru');
            $table->string('name_en');
            $table->text('description_tm')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->string('icon')->default('💧');
            $table->timestamps();
        });

        Schema::create('waters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('volume'); // 0.5L, 1.5L, 5L, 19L
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(100);
            $table->string('ph_level')->default('7.4');
            $table->string('mineral_content')->nullable(); // e.g. "Ca, Mg, K"
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('water_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // pending, processing, delivered, cancelled
            $table->string('delivery_address');
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->text('answer')->nullable();
            $table->string('status')->default('pending'); // pending, answered
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('waters');
        Schema::dropIfExists('categories');
    }
};
