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
        Schema::create('ordered_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade'); // ON DELETE CASCADE
            $table->foreignId('variant_id')
                ->constrained('product_varients'); // References product_variants.variant_id
            $table->integer('quantity');
            $table->decimal('price');
            $table->timestamps();
        });
    }
    // CREATE TABLE order_items (
//     order_item_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     order_id BIGINT NOT NULL,
//     variant_id BIGINT NOT NULL,
//     quantity INT NOT NULL,
//     price DECIMAL(10,2) NOT NULL,
//     FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
//     FOREIGN KEY (variant_id) REFERENCES product_variants(variant_id)
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordered_items');
    }
};
