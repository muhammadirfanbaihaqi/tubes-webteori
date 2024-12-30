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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('grand_total', 10,2)->nullable();
            $table->String('payment_method')->nullable();
            $table->String('payment_status')->nullable();
            $table->enum('status', ['pending', 'sedang dimasak', 'matang' ,'cancelled'])->default('pending');
            $table->string('currency')->nullable();
            $table->decimal('shipping_amount')->nullable();
            $table->string('shipping_method')->nullable();
            $table->Text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
