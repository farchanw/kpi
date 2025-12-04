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
        Schema::create('kpi_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('evaluators')->onDelete('cascade');
            
            $table->string('key_perf_area');
            $table->foreignId('kpi_template_id')->constrained('kpi_templates')->onDelete('cascade');
            $table->unsignedInteger('weight');
            $table->integer('target');
            $table->integer('actual');
            $table->float('score');
            $table->float('final_score');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kpi_entries');
    }
};
