<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ServiceChargeSeeder extends Seeder
{
    /**
     * Seed Okra IT brand, Service Charge category, and service charge products.
     *
     * Model code convention: SC-{Location}-W{Months}-{Price}
     *   SC  = Service Charge
     *   IK  = Inside Khulna
     *   OK  = Outside Khulna
     *   W12 = 12-month (1 Year) warranty
     *   W6  = 6-month warranty
     */
    public function run(): void
    {
        // 1. Brand: Okra IT
        $brand = Brand::firstOrCreate(
            ['slug' => 'okra-it'],
            [
                'name'        => 'Okra IT',
                'slug'        => 'okra-it',
                'description' => 'Okra IT — Professional IT & Surveillance Systems provider, Khulna.',
            ]
        );

        // 2. Category: Service Charge
        $category = Category::firstOrCreate(
            ['slug' => 'service-charge'],
            [
                'name'        => 'Service Charge',
                'slug'        => 'service-charge',
                'description' => 'Per-camera installation and service warranty charges based on location and warranty period.',
            ]
        );

        // 3. Service Charge Products
        $products = [
            [
                'name'            => '500 Taka Per Camera · Inside Khulna · 1 Year Service Warranty',
                'slug'            => 'sc-ik-w12-500',
                'model'           => 'SC-IK-W12-500',
                'brand_id'        => $brand->id,
                'category_id'     => $category->id,
                'base_price'      => 500.00,
                'selling_price'   => 500.00,
                'quotation_price' => 500.00,
                'description'     => 'Per-camera service charge for installations Inside Khulna with 1 Year (12 months) service warranty.',
            ],
            [
                'name'            => '400 Taka Per Camera · Inside Khulna · 6 Months Service Warranty',
                'slug'            => 'sc-ik-w6-400',
                'model'           => 'SC-IK-W6-400',
                'brand_id'        => $brand->id,
                'category_id'     => $category->id,
                'base_price'      => 400.00,
                'selling_price'   => 400.00,
                'quotation_price' => 400.00,
                'description'     => 'Per-camera service charge for installations Inside Khulna with 6 Months service warranty.',
            ],
            [
                'name'            => '1000 Taka Per Camera · Outside Khulna · 1 Year Service Warranty',
                'slug'            => 'sc-ok-w12-1000',
                'model'           => 'SC-OK-W12-1000',
                'brand_id'        => $brand->id,
                'category_id'     => $category->id,
                'base_price'      => 1000.00,
                'selling_price'   => 1000.00,
                'quotation_price' => 1000.00,
                'description'     => 'Per-camera service charge for installations Outside Khulna with 1 Year (12 months) service warranty.',
            ],
            [
                'name'            => '800 Taka Per Camera · Outside Khulna · 6 Months Service Warranty',
                'slug'            => 'sc-ok-w6-800',
                'model'           => 'SC-OK-W6-800',
                'brand_id'        => $brand->id,
                'category_id'     => $category->id,
                'base_price'      => 800.00,
                'selling_price'   => 800.00,
                'quotation_price' => 800.00,
                'description'     => 'Per-camera service charge for installations Outside Khulna with 6 Months service warranty.',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
