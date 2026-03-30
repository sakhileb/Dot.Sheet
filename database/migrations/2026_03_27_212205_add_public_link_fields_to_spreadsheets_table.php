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
        Schema::table('spreadsheets', function (Blueprint $table) {
            $table->boolean('public_enabled')->default(false)->after('settings');
            $table->string('public_token')->nullable()->unique()->after('public_enabled');
            $table->timestamp('public_expires_at')->nullable()->after('public_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spreadsheets', function (Blueprint $table) {
            $table->dropColumn(['public_enabled', 'public_token', 'public_expires_at']);
        });
    }
};
