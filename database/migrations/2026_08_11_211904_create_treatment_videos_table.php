<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_videos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('treatment_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title')->nullable();

            $table->string('video_path');

            $table->text('description')->nullable();

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_videos');
    }
};