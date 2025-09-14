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
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade'); // ON DELETE CASCADE
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['esewa', 'khalti', 'cash_on_delivery', 'bank_transfer']);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('transaction_id', 255)->nullable();
            $table->timestamps();
        });
    }
// CREATE TABLE payments (
//     payment_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     order_id BIGINT NOT NULL,
//     amount DECIMAL(12,2) NOT NULL,
//     method ENUM('card', 'paypal', 'cash_on_delivery', 'bank_transfer') NOT NULL,
//     status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
//     transaction_id VARCHAR(255),
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
