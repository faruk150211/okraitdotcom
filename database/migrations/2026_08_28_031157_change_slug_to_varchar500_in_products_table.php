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
        Schema::table('products', function (Blueprint $table) {
            // Widen to varchar(500) — stays indexable (MySQL limit ~768 chars for utf8mb4 unique indexes)
            // Note: unique index already exists, so we don't re-declare it here
            $table->string('slug', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 255)->unique()->change(); // revert to varchar(255)
        });
    }
};
