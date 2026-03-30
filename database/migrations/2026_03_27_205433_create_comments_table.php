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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spreadsheet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->integer('row_index');
            $table->integer('col_index');
            $table->text('content');
            $table->boolean('resolved')->default(false);
            $table->timestamps();

            $table->index(['spreadsheet_id', 'row_index', 'col_index']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
