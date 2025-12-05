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
        Schema::create('division_evaluation_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_evaluation_id')->constrained('division_evaluations')->onDelete('cascade');
            
            $table->string('key_perf_area');
            $table->foreignId('kpi_template_id')->constrained('kpi_templates')->onDelete('cascade');
            $table->unsignedInteger('weight');
            $table->integer('target');
            $table->integer('actual');
            $table->integer('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_evaluation_entries');
    }
};
