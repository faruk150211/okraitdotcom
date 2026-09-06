<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('total_profit', 15, 2)->default(0)->after('paid_amount');
        });

        Schema::table('sale_items', function (Blueprint $table) {
            $table->decimal('base_unit_price', 15, 2)->default(0)->after('quantity');
            $table->decimal('profit', 15, 2)->default(0)->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn(['base_unit_price', 'profit']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('total_profit');
        });
    }
};
