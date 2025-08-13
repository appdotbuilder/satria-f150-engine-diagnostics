<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diagnosis_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_id')->constrained()->onDelete('cascade');
            $table->json('required_symptoms');
            $table->integer('confidence_score')->default(0);
            $table->integer('priority')->default(1);
            $table->text('rule_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for performance
            $table->index('diagnosis_id');
            $table->index('confidence_score');
            $table->index('priority');
            $table->index('is_active');
            $table->index(['is_active', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_rules');
    }
};