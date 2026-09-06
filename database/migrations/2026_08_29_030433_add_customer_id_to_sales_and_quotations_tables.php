<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add customer_id columns
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
        });

        // 2. Data Migration: Extract unique customers and link them
        // First quotations
        $quotations = DB::table('quotations')->whereNotNull('customer_mobile')->orderBy('created_at', 'asc')->get();
        foreach ($quotations as $q) {
            $customer = DB::table('customers')->where('mobile', $q->customer_mobile)->first();
            if (!$customer) {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => $q->customer_name ?? 'Unknown',
                    'mobile' => $q->customer_mobile,
                    'address' => $q->customer_address,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $customerId = $customer->id;
            }
            DB::table('quotations')->where('id', $q->id)->update(['customer_id' => $customerId]);
        }

        // Then sales
        $sales = DB::table('sales')->whereNotNull('customer_mobile')->orderBy('created_at', 'asc')->get();
        foreach ($sales as $s) {
            $customer = DB::table('customers')->where('mobile', $s->customer_mobile)->first();
            if (!$customer) {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => $s->customer_name ?? 'Unknown',
                    'mobile' => $s->customer_mobile,
                    'address' => $s->customer_address,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $customerId = $customer->id;
            }
            DB::table('sales')->where('id', $s->id)->update(['customer_id' => $customerId]);
        }
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
