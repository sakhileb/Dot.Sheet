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
        Schema::create('workflow_execution_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spreadsheet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('triggered_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('rule_id')->index();
            $table->string('rule_name');
            $table->string('rule_action')->nullable();
            $table->string('rule_operator', 8)->nullable();
            $table->string('rule_expected_value')->nullable();
            $table->unsignedInteger('row_index');
            $table->unsignedInteger('col_index');
            $table->string('cell_reference', 16);
            $table->text('actual_value')->nullable();
            $table->json('notification_channels')->nullable();
            $table->string('status', 32)->default('triggered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_execution_logs');
    }
};
