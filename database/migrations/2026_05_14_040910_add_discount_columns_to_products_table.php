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
        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'discount_percentage')) {

                $table->integer('discount_percentage')
                    ->default(0);
            }

            if (!Schema::hasColumn('products', 'is_discount')) {

                $table->boolean('is_discount')
                    ->default(false);
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            if (Schema::hasColumn('products', 'discount_percentage')) {

                $table->dropColumn('discount_percentage');
            }

            if (Schema::hasColumn('products', 'is_discount')) {

                $table->dropColumn('is_discount');
            }

        });
    }
};