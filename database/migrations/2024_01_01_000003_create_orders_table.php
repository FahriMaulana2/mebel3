<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi user (optional)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Nomor order
            $table->string('order_number')->unique();

            // Data customer (WA checkout)
            $table->string('fullname');
            $table->string('phone');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');

            // Pengiriman
            $table->string('courier')->nullable();

            // Data produk (JSON cart)
            $table->json('items');

            // Harga
            $table->decimal('total_amount', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2);

            // Status
            $table->enum('status', [
                'pending',
                'processed',
                'shipped',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}