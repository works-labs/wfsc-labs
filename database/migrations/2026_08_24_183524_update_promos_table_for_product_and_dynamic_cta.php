<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            // Tambahkan treatment_product_id HANYA jika belum ada
            if (! Schema::hasColumn('promos', 'treatment_product_id')) {
                $table->foreignId('treatment_product_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('treatment_products')
                    ->nullOnDelete();
            }

            // Hapus cta_url jika masih ada
            if (Schema::hasColumn('promos', 'cta_url')) {
                $table->dropColumn('cta_url');
            }

            // Tambahkan cta_type jika belum ada
            if (! Schema::hasColumn('promos', 'cta_type')) {
                $table->string('cta_type')->default('internal')->after('image');
            }

            // Tambahkan cta_target jika belum ada
            if (! Schema::hasColumn('promos', 'cta_target')) {
                $table->string('cta_target')->nullable()->after('cta_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            if (Schema::hasColumn('promos', 'treatment_product_id')) {
                $table->dropForeign(['treatment_product_id']);
                $table->dropColumn('treatment_product_id');
            }

            if (Schema::hasColumn('promos', 'cta_type')) {
                $table->dropColumn('cta_type');
            }

            if (Schema::hasColumn('promos', 'cta_target')) {
                $table->dropColumn('cta_target');
            }

            if (! Schema::hasColumn('promos', 'cta_url')) {
                $table->string('cta_url')->nullable()->after('image');
            }
        });
    }
};