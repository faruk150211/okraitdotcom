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
        Schema::table('payments', function (Blueprint $table) {
            // First drop the foreign key and column
            $table->dropForeign(['quotation_id']);
            $table->dropColumn('quotation_id');
            // Then add the new sale_id
            $table->foreignId('sale_id')->nullable()->after('id')->constrained('sales')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropColumn('sale_id');
            $table->foreignId('quotation_id')->nullable()->constrained('quotations')->cascadeOnDelete();
        });
    }
};
