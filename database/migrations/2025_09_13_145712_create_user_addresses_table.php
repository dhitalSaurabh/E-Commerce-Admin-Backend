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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade'); // ON DELETE CASCADE
            $table->string('full_name', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }
// CREATE TABLE addresses (
//     address_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     user_id BIGINT NOT NULL,
//     full_name VARCHAR(150),
//     phone VARCHAR(20),
//     street VARCHAR(255),
//     city VARCHAR(100),
//     state VARCHAR(100),
//     postal_code VARCHAR(20),
//     country VARCHAR(100),
//     is_default BOOLEAN DEFAULT FALSE,
//     FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
