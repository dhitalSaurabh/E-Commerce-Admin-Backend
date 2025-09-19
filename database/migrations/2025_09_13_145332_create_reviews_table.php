<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained('products')->onDelete('cascade'); // References products.product_id
            $table->integer('rating')->unsigned(); // rating between 1 and 5
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }
    // CREATE TABLE reviews (
//     review_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     product_id BIGINT NOT NULL,
//     user_id BIGINT NOT NULL,
//     rating INT CHECK(rating BETWEEN 1 AND 5),
//     comment TEXT,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (product_id) REFERENCES products(product_id),
//     FOREIGN KEY (user_id) REFERENCES users(user_id)
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
