<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->enum('size', ['small', 'medium', 'large']);
            $table->boolean('pepperoni')->default(false);
            $table->boolean('extra_cheese')->default(false);
            $table->decimal('base_price', 8, 2);
            $table->decimal('pepperoni_price', 8, 2)->nullable();
            $table->decimal('extra_cheese_price', 8, 2)->nullable();
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};
