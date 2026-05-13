<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cek dan tambahkan kolom slug
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            
            // Cek dan tambahkan kolom category
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            
            // Cek dan tambahkan kolom images
            if (!Schema::hasColumn('products', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
            
            // Cek dan tambahkan kolom is_active
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('stock');
            }
            
            // Cek dan tambahkan kolom is_featured
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
            
            // Cek dan tambahkan kolom views
            if (!Schema::hasColumn('products', 'views')) {
                $table->integer('views')->default(0)->after('is_featured');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['slug', 'category', 'images', 'is_active', 'is_featured', 'views'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};