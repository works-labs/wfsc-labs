<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treatment_before_afters', function (Blueprint $table) {
            $table->renameColumn('before_image', 'before_media');
            $table->renameColumn('after_image', 'after_media');
        });
    }

    public function down(): void
    {
        Schema::table('treatment_before_afters', function (Blueprint $table) {
            $table->renameColumn('before_media', 'before_image');
            $table->renameColumn('after_media', 'after_image');
        });
    }
};