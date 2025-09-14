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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade'); // ON DELETE CASCADE
            $table->foreignId('variant_id')
                  ->constrained('product_variants'); // References product_variants.variant_id
            $table->integer('quantity');
            $table->timestamp('added_at')->useCurrent(); // Default CURRENT_TIMESTAMP
            $table->timestamps();
        });
    }
// CREATE TABLE cart_items (
//     cart_item_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     user_id BIGINT NOT NULL,
//     variant_id BIGINT NOT NULL,
//     quantity INT NOT NULL,
//     added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
//     FOREIGN KEY (variant_id) REFERENCES product_variants(variant_id)
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
