<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skincare_category_product', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('skincare_category_id');
            $table->index(['skincare_category_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::table('skincare_category_product', function (Blueprint $table) {
            $table->dropIndex(['skincare_category_id', 'sort_order']);
            $table->dropColumn('sort_order');
        });
    }
};
