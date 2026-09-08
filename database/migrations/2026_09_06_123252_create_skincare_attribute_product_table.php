<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skincare_attribute_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('skincare_product_id')
                ->constrained('skincare_products')
                ->cascadeOnDelete();

            $table->foreignId('skincare_attribute_id')
                ->constrained('skincare_attributes')
                ->cascadeOnDelete();

            $table->unique(
                ['skincare_product_id', 'skincare_attribute_id'],
                'attribute_product_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skincare_attribute_product');
    }
};