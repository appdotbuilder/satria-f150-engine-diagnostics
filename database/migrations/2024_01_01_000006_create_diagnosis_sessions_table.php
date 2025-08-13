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
        Schema::create('diagnosis_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique()->comment('Unique session identifier');
            $table->json('selected_symptoms')->comment('Array of selected symptom IDs');
            $table->json('diagnosis_results')->nullable()->comment('Array of diagnosis results with confidence scores');
            $table->timestamp('diagnosed_at')->nullable()->comment('When diagnosis was completed');
            $table->string('motorcycle_model')->default('Suzuki Satria F150')->comment('Motorcycle model');
            $table->integer('motorcycle_year')->nullable()->comment('Motorcycle year');
            $table->integer('mileage')->nullable()->comment('Motorcycle mileage');
            $table->timestamps();
            
            // Indexes for performance
            $table->index('session_id');
            $table->index('diagnosed_at');
            $table->index('created_at');
            $table->index('motorcycle_model');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_sessions');
    }
};