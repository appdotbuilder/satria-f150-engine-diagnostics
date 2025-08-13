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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Diagnosis name');
            $table->text('description')->comment('Detailed description of the engine damage');
            $table->text('possible_causes')->comment('Possible causes of the damage');
            $table->text('recommended_actions')->comment('Recommended repair actions');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->comment('Severity level of the damage');
            $table->decimal('estimated_cost_min', 10, 2)->nullable()->comment('Minimum estimated repair cost');
            $table->decimal('estimated_cost_max', 10, 2)->nullable()->comment('Maximum estimated repair cost');
            $table->boolean('is_active')->default(true)->comment('Whether diagnosis is active');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('name');
            $table->index('severity');
            $table->index('is_active');
            $table->index(['is_active', 'severity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};