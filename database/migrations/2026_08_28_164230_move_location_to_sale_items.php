<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add location_id to sale_items
        Schema::table('sale_items', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('product_id');
        });

        // 2. Seed the location_id from sales to sale_items
        DB::statement('
            UPDATE sale_items 
            JOIN sales ON sale_items.sale_id = sales.id 
            SET sale_items.location_id = sales.location_id
        ');

        // 3. Make location_id not null and add foreign key constraint
        Schema::table('sale_items', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
        });

        // 4. Drop location_id from sales
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Re-add location_id to sales
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('customer_address');
        });

        // 2. Seed location_id from sale_items back to sales (take the first item's location)
        DB::statement('
            UPDATE sales
            SET location_id = (
                SELECT location_id 
                FROM sale_items 
                WHERE sale_items.sale_id = sales.id 
                LIMIT 1
            )
        ');

        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
        });

        // 3. Drop location_id from sale_items
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};
