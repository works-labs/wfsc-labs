<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->string('cta_type')
                ->default('internal')
                ->after('cta_text');

            $table->string('cta_target')
                ->nullable()
                ->after('cta_type');

            $table->dropColumn('cta_url');
        });
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table) {
            $table->string('cta_url')
                ->nullable()
                ->after('cta_text');

            $table->dropColumn([
                'cta_type',
                'cta_target',
            ]);
        });
    }
};