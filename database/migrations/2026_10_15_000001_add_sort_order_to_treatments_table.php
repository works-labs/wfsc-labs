<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->after('category_id');
            $table->index(['category_id', 'sort_order']);
        });

        $nextOrder = [];
        DB::table('treatments')
            ->orderBy('category_id')
            ->orderBy('id')
            ->get(['id', 'category_id'])
            ->each(function ($treatment) use (&$nextOrder): void {
                $nextOrder[$treatment->category_id] = ($nextOrder[$treatment->category_id] ?? 0) + 1;
                DB::table('treatments')->where('id', $treatment->id)
                    ->update(['sort_order' => $nextOrder[$treatment->category_id]]);
            });
    }

    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'sort_order']);
            $table->dropColumn('sort_order');
        });
    }
};
