<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('mode')->default('desktop')->after('placement');
            $table->index(['placement', 'mode', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropIndex(['placement', 'mode', 'is_active']);
            $table->dropColumn('mode');
        });
    }
};
