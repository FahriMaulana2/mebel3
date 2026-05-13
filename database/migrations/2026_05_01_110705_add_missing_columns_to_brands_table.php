<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            // Tambahkan kolom slug jika belum ada
            if (!Schema::hasColumn('brands', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            
            // Tambahkan kolom description jika belum ada
            if (!Schema::hasColumn('brands', 'description')) {
                $table->text('description')->nullable()->after('slug');
            }
            
            // Tambahkan kolom logo jika belum ada
            if (!Schema::hasColumn('brands', 'logo')) {
                $table->string('logo')->nullable()->after('description');
            }
            
            // Tambahkan kolom is_active jika belum ada
            if (!Schema::hasColumn('brands', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('logo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $columns = ['slug', 'description', 'logo', 'is_active'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('brands', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};