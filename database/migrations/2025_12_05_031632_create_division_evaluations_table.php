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
        Schema::create('division_evaluations', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');

            $table->foreignId('evaluator_id')->constrained('evaluators')->onDelete('cascade');
            
            $table->date('evaluation_date');
            $table->integer('total_weight')->default(0);
            $table->integer('final_score')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_evaluations');
    }
};
