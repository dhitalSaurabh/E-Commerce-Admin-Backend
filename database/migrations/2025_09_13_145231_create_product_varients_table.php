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
        Schema::create('product_varients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('product_id')
                  ->constrained('products') // References products.product_id
                  ->onDelete('cascade'); // ON DELETE CASCADE
            $table->string('size', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('material', 100)->nullable();
            $table->decimal('additional_price', 10, 2)->default(0);
            $table->string('sku', 100)->unique()->nullable();
            $table->timestamps();
        });
    }
// CREATE TABLE product_variants (
//     variant_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     product_id BIGINT NOT NULL,
//     size VARCHAR(50),
//     color VARCHAR(50),
//     material VARCHAR(100),
//     additional_price DECIMAL(10,2) DEFAULT 0,
//     sku VARCHAR(100) UNIQUE,
//     FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
// );
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_varients');
    }
};
