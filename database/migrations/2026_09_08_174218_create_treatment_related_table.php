<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_related', function (Blueprint $table) {
            $table->id();

            $table->foreignId('treatment_id')
                ->constrained('treatments')
                ->cascadeOnDelete();

            $table->foreignId('related_treatment_id')
                ->constrained('treatments')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'treatment_id',
                'related_treatment_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_related');
    }
};