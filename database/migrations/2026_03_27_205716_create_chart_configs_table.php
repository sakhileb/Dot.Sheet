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
        Schema::create('chart_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spreadsheet_id')->constrained()->cascadeOnDelete();
            $table->string('title')->default('Chart');
            $table->string('type')->default('bar'); // bar, line, pie, scatter, area, doughnut
            $table->string('data_range'); // e.g. "A1:C10"
            $table->string('labels_range')->nullable(); // e.g. "A1:A10"
            $table->json('options')->nullable(); // Chart.js options overrides
            $table->integer('position_row')->default(1);
            $table->integer('position_col')->default(5);
            $table->integer('width')->default(6); // columns wide
            $table->integer('height')->default(10); // rows tall
            $table->timestamps();

            $table->index('spreadsheet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chart_configs');
    }
};
