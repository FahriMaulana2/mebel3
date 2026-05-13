<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cek dan tambahkan kolom grand_total
            if (!Schema::hasColumn('orders', 'grand_total')) {
                $table->decimal('grand_total', 15, 2)->default(0)->after('total_amount');
            }
            
            // Cek dan tambahkan kolom shipping_cost
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 15, 2)->default(0)->after('total_amount');
            }
            
            // Cek dan tambahkan kolom order_number jika belum ada
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->after('id');
            }
            
            // Cek dan tambahkan kolom user_id jika belum ada
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }
            
            // Cek dan tambahkan kolom notes jika belum ada
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['grand_total', 'shipping_cost', 'order_number', 'user_id', 'notes'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};