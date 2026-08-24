<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->foreignId('treatment_product_id')
                ->nullable()
                ->constrained('treatment_products')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropForeign(['treatment_product_id']);
            $table->dropColumn('treatment_product_id');
        });
    }
};