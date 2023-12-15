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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->integer('fee_free_amount')->nullable();
            $table->string('token')->nullable();
            $table->string('status_code')->nullable();
            $table->string('ref_num')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('user_card_number')->nullable();
            $table->string('tracking_code')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('order_id')->nullable()->constrained('orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
