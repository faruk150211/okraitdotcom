<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        // 1. Create Brands
        $brandsData = [
            ['name' => 'Hikvision', 'slug' => 'hikvision', 'description' => 'Hikvision Digital Technology Co., Ltd. is a Chinese state-owned manufacturer and supplier of video surveillance equipment.'],
            ['name' => 'Dahua', 'slug' => 'dahua', 'description' => 'Dahua Technology Co., Ltd. is a Chinese provider of video surveillance products and services.'],
            ['name' => 'UniView', 'slug' => 'uniview', 'description' => 'Uniview is the pioneer and leader of IP video surveillance.'],
            ['name' => 'Toshiba', 'slug' => 'toshiba', 'description' => 'Toshiba Corporation is a Japanese multinational conglomerate offering surveillance hard drives.'],
            ['name' => 'BRB', 'slug' => 'brb', 'description' => 'BRB Cables is a leading wire and cable manufacturer.'],
        ];

        $brands = [];
        foreach ($brandsData as $b) {
            $brands[$b['slug']] = Brand::firstOrCreate(['slug' => $b['slug']], $b);
        }

        // 2. Create Categories
        $categoriesData = [
            ['name' => 'IP Camera', 'slug' => 'ip-camera', 'description' => 'Internet Protocol cameras used for digital video surveillance.'],
            ['name' => 'HD Camera', 'slug' => 'hd-camera', 'description' => 'High Definition analog cameras.'],
            ['name' => 'HDD', 'slug' => 'hdd', 'description' => 'Hard Disk Drives optimized for 24/7 video surveillance storage.'],
            ['name' => 'Cable', 'slug' => 'cable', 'description' => 'Coaxial, UTP, and power cables.'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // 3. Create Products
        $productsData = [
            [
                'name' => 'Hikvision 4MP IP Bullet Camera',
                'slug' => 'hikvision-4mp-ip-bullet-camera',
                'model' => 'DS-2CD2043G2-I',
                'brand_id' => $brands['hikvision']->id,
                'category_id' => $categories['ip-camera']->id,
                'base_price' => 45.00,
                'selling_price' => 70.00,
                'quotation_price' => 65.00,
                'description' => 'Hikvision DS-2CD2043G2-I 4MP AcuSense Fixed Bullet Network Camera.',
            ],
            [
                'name' => 'Dahua 2MP HD Dome Camera',
                'slug' => 'dahua-2mp-hd-dome-camera',
                'model' => 'DH-HAC-HDW1200TRQN',
                'brand_id' => $brands['dahua']->id,
                'category_id' => $categories['hd-camera']->id,
                'base_price' => 22.50,
                'selling_price' => 38.00,
                'quotation_price' => 35.00,
                'description' => 'Dahua 2MP HDCVI IR Eyeball Camera.',
            ],
            [
                'name' => 'UniView 8MP IP Dome Camera',
                'slug' => 'uniview-8mp-ip-dome-camera',
                'model' => 'IPC328SR3-ADF40K',
                'brand_id' => $brands['uniview']->id,
                'category_id' => $categories['ip-camera']->id,
                'base_price' => 85.00,
                'selling_price' => 140.00,
                'quotation_price' => 130.00,
                'description' => 'Uniview 4K Ultra HD Vandal-resistant Dome Camera.',
            ],
            [
                'name' => 'Toshiba 1TB Surveillance Hard Drive',
                'slug' => 'toshiba-1tb-surveillance-hard-drive',
                'model' => 'HDWT110UZSVA',
                'brand_id' => $brands['toshiba']->id,
                'category_id' => $categories['hdd']->id,
                'base_price' => 35.00,
                'selling_price' => 55.00,
                'quotation_price' => 50.00,
                'description' => 'Toshiba S300 1TB 3.5-inch Surveillance Hard Drive.',
            ],
            [
                'name' => 'Toshiba 2TB Surveillance Hard Drive',
                'slug' => 'toshiba-2tb-surveillance-hard-drive',
                'model' => 'HDWT120UZSVA',
                'brand_id' => $brands['toshiba']->id,
                'category_id' => $categories['hdd']->id,
                'base_price' => 55.00,
                'selling_price' => 85.00,
                'quotation_price' => 80.00,
                'description' => 'Toshiba S300 2TB 3.5-inch Surveillance Hard Drive.',
            ],
            [
                'name' => 'BRB Cat6 UTP Cable 305m',
                'slug' => 'brb-cat6-utp-cable-305m',
                'model' => 'BRB-CAT6-UTP',
                'brand_id' => $brands['brb']->id,
                'category_id' => $categories['cable']->id,
                'base_price' => 58.00,
                'selling_price' => 90.00,
                'quotation_price' => 85.00,
                'description' => 'BRB Premium Copper Cat6 UTP Network Cable (Full box).',
            ],
            [
                'name' => 'BRB 3-Core Flexible Cable 100m',
                'slug' => 'brb-3-core-flexible-cable-100m',
                'model' => 'BRB-3C-FLX',
                'brand_id' => $brands['brb']->id,
                'category_id' => $categories['cable']->id,
                'base_price' => 28.00,
                'selling_price' => 45.00,
                'quotation_price' => 42.00,
                'description' => 'BRB 3-Core Multi-strand copper power cable.',
            ],
        ];

        foreach ($productsData as $p) {
            Product::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // Seed Okra IT service charge products
        $this->call(ServiceChargeSeeder::class);
    }
}
