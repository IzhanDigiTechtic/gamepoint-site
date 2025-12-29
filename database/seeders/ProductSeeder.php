<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create CPU category
        $cpuCategory = Category::firstOrCreate(
            ['slug' => 'cpus-processors'],
            [
                'name' => 'CPUs & Processors',
                'is_active' => true,
                'display_order' => 1,
            ]
        );

        // Get or create brands
        $brands = [
            Brand::firstOrCreate(['slug' => 'intel'], ['name' => 'Intel', 'is_active' => true]),
            Brand::firstOrCreate(['slug' => 'amd'], ['name' => 'AMD', 'is_active' => true]),
            Brand::firstOrCreate(['slug' => 'apple'], ['name' => 'Apple', 'is_active' => true]),
        ];

        // CPU product data
        $cpuProducts = [
            // Intel CPUs
            ['name' => 'Intel Core i9-14900K Desktop Processor', 'brand' => 'Intel', 'price' => 85000, 'sale_price' => 79900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '24 (8P+16E)', 'Threads' => '32', 'Base Clock' => '3.2 GHz', 'Boost Clock' => '6.0 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake Refresh'],
             'description' => 'High-performance desktop processor with 24 cores and 32 threads, perfect for gaming and content creation.'],
            
            ['name' => 'Intel Core i7-14700K Desktop Processor', 'brand' => 'Intel', 'price' => 65000, 'sale_price' => 59900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '20 (8P+12E)', 'Threads' => '28', 'Base Clock' => '3.4 GHz', 'Boost Clock' => '5.6 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake Refresh'],
             'description' => 'Powerful 20-core processor ideal for gaming and professional workloads.'],
            
            ['name' => 'Intel Core i5-14600K Desktop Processor', 'brand' => 'Intel', 'price' => 45000, 'sale_price' => 41900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '14 (6P+8E)', 'Threads' => '20', 'Base Clock' => '3.5 GHz', 'Boost Clock' => '5.3 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake Refresh'],
             'description' => 'Excellent mid-range processor for gaming and productivity.'],
            
            ['name' => 'Intel Core i9-13900K Desktop Processor', 'brand' => 'Intel', 'price' => 75000, 'sale_price' => null, 'condition' => 'used', 'warranty' => true, 'warranty_months' => 24,
             'specs' => ['Cores' => '24 (8P+16E)', 'Threads' => '32', 'Base Clock' => '3.0 GHz', 'Boost Clock' => '5.8 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake'],
             'description' => 'Previous generation flagship processor, still excellent performance.'],
            
            ['name' => 'Intel Core i7-13700K Desktop Processor', 'brand' => 'Intel', 'price' => 58000, 'sale_price' => 54900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '16 (8P+8E)', 'Threads' => '24', 'Base Clock' => '3.4 GHz', 'Boost Clock' => '5.4 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake'],
             'description' => 'High-performance processor for gaming and content creation.'],
            
            ['name' => 'Intel Core i5-13600K Desktop Processor', 'brand' => 'Intel', 'price' => 42000, 'sale_price' => 38900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '14 (6P+8E)', 'Threads' => '20', 'Base Clock' => '3.5 GHz', 'Boost Clock' => '5.1 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake'],
             'description' => 'Great value processor for gaming and productivity tasks.'],
            
            ['name' => 'Intel Core i9-12900K Desktop Processor', 'brand' => 'Intel', 'price' => 65000, 'sale_price' => null, 'condition' => 'used', 'warranty' => false, 'warranty_months' => null,
             'specs' => ['Cores' => '16 (8P+8E)', 'Threads' => '24', 'Base Clock' => '3.2 GHz', 'Boost Clock' => '5.2 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Alder Lake'],
             'description' => 'Previous generation flagship, used condition, no warranty.'],
            
            ['name' => 'Intel Core i7-12700K Desktop Processor', 'brand' => 'Intel', 'price' => 52000, 'sale_price' => 47900, 'condition' => 'refurbished', 'warranty' => true, 'warranty_months' => 12,
             'specs' => ['Cores' => '12 (8P+4E)', 'Threads' => '20', 'Base Clock' => '3.6 GHz', 'Boost Clock' => '5.0 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Alder Lake'],
             'description' => 'Refurbished processor with 12-month warranty.'],
            
            ['name' => 'Intel Core i5-12600K Desktop Processor', 'brand' => 'Intel', 'price' => 38000, 'sale_price' => null, 'condition' => 'used', 'warranty' => true, 'warranty_months' => 18,
             'specs' => ['Cores' => '10 (6P+4E)', 'Threads' => '16', 'Base Clock' => '3.7 GHz', 'Boost Clock' => '4.9 GHz', 'TDP' => '125W', 'Socket' => 'LGA 1700', 'Architecture' => 'Alder Lake'],
             'description' => 'Used processor with remaining warranty.'],
            
            ['name' => 'Intel Core i3-13100 Desktop Processor', 'brand' => 'Intel', 'price' => 25000, 'sale_price' => 22900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '4', 'Threads' => '8', 'Base Clock' => '3.4 GHz', 'Boost Clock' => '4.5 GHz', 'TDP' => '60W', 'Socket' => 'LGA 1700', 'Architecture' => 'Raptor Lake'],
             'description' => 'Budget-friendly quad-core processor for everyday computing.'],
            
            // AMD CPUs
            ['name' => 'AMD Ryzen 9 7950X Desktop Processor', 'brand' => 'AMD', 'price' => 95000, 'sale_price' => 89900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '16', 'Threads' => '32', 'Base Clock' => '4.5 GHz', 'Boost Clock' => '5.7 GHz', 'TDP' => '170W', 'Socket' => 'AM5', 'Architecture' => 'Zen 4'],
             'description' => 'Flagship AMD processor with 16 cores, perfect for content creation and gaming.'],
            
            ['name' => 'AMD Ryzen 9 7900X Desktop Processor', 'brand' => 'AMD', 'price' => 75000, 'sale_price' => 69900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '12', 'Threads' => '24', 'Base Clock' => '4.7 GHz', 'Boost Clock' => '5.6 GHz', 'TDP' => '170W', 'Socket' => 'AM5', 'Architecture' => 'Zen 4'],
             'description' => 'High-performance 12-core processor for professionals and enthusiasts.'],
            
            ['name' => 'AMD Ryzen 7 7800X3D Desktop Processor', 'brand' => 'AMD', 'price' => 65000, 'sale_price' => 59900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '8', 'Threads' => '16', 'Base Clock' => '4.2 GHz', 'Boost Clock' => '5.0 GHz', 'TDP' => '120W', 'Socket' => 'AM5', 'Architecture' => 'Zen 4', '3D V-Cache' => '96MB'],
             'description' => 'Gaming-focused processor with 3D V-Cache technology for exceptional gaming performance.'],
            
            ['name' => 'AMD Ryzen 7 7700X Desktop Processor', 'brand' => 'AMD', 'price' => 55000, 'sale_price' => 51900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '8', 'Threads' => '16', 'Base Clock' => '4.5 GHz', 'Boost Clock' => '5.4 GHz', 'TDP' => '105W', 'Socket' => 'AM5', 'Architecture' => 'Zen 4'],
             'description' => 'Excellent 8-core processor for gaming and productivity.'],
            
            ['name' => 'AMD Ryzen 5 7600X Desktop Processor', 'brand' => 'AMD', 'price' => 42000, 'sale_price' => 38900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '6', 'Threads' => '12', 'Base Clock' => '4.7 GHz', 'Boost Clock' => '5.3 GHz', 'TDP' => '105W', 'Socket' => 'AM5', 'Architecture' => 'Zen 4'],
             'description' => 'Great value 6-core processor for gaming and everyday tasks.'],
            
            ['name' => 'AMD Ryzen 9 5950X Desktop Processor', 'brand' => 'AMD', 'price' => 85000, 'sale_price' => null, 'condition' => 'used', 'warranty' => true, 'warranty_months' => 24,
             'specs' => ['Cores' => '16', 'Threads' => '32', 'Base Clock' => '3.4 GHz', 'Boost Clock' => '4.9 GHz', 'TDP' => '105W', 'Socket' => 'AM4', 'Architecture' => 'Zen 3'],
             'description' => 'Previous generation flagship, used condition with remaining warranty.'],
            
            ['name' => 'AMD Ryzen 7 5800X3D Desktop Processor', 'brand' => 'AMD', 'price' => 55000, 'sale_price' => 51900, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '8', 'Threads' => '16', 'Base Clock' => '3.4 GHz', 'Boost Clock' => '4.5 GHz', 'TDP' => '105W', 'Socket' => 'AM4', 'Architecture' => 'Zen 3', '3D V-Cache' => '96MB'],
             'description' => 'Gaming champion with 3D V-Cache technology on AM4 platform.'],
            
            ['name' => 'AMD Ryzen 7 5800X Desktop Processor', 'brand' => 'AMD', 'price' => 48000, 'sale_price' => null, 'condition' => 'used', 'warranty' => false, 'warranty_months' => null,
             'specs' => ['Cores' => '8', 'Threads' => '16', 'Base Clock' => '3.8 GHz', 'Boost Clock' => '4.7 GHz', 'TDP' => '105W', 'Socket' => 'AM4', 'Architecture' => 'Zen 3'],
             'description' => 'Used processor, no warranty remaining.'],
            
            ['name' => 'AMD Ryzen 5 5600X Desktop Processor', 'brand' => 'AMD', 'price' => 35000, 'sale_price' => 32900, 'condition' => 'refurbished', 'warranty' => true, 'warranty_months' => 12,
             'specs' => ['Cores' => '6', 'Threads' => '12', 'Base Clock' => '3.7 GHz', 'Boost Clock' => '4.6 GHz', 'TDP' => '65W', 'Socket' => 'AM4', 'Architecture' => 'Zen 3'],
             'description' => 'Refurbished 6-core processor with 12-month warranty.'],
            
            ['name' => 'AMD Ryzen 5 5500 Desktop Processor', 'brand' => 'AMD', 'price' => 28000, 'sale_price' => null, 'condition' => 'new', 'warranty' => true, 'warranty_months' => 36,
             'specs' => ['Cores' => '6', 'Threads' => '12', 'Base Clock' => '3.6 GHz', 'Boost Clock' => '4.2 GHz', 'TDP' => '65W', 'Socket' => 'AM4', 'Architecture' => 'Zen 3'],
             'description' => 'Budget-friendly 6-core processor for entry-level builds.'],
        ];

        // Generate 100 products by creating variations
        $productCount = 0;
        $baseProducts = $cpuProducts;
        
        while ($productCount < 100) {
            foreach ($baseProducts as $baseProduct) {
                if ($productCount >= 100) break;
                
                $brand = collect($brands)->firstWhere('name', $baseProduct['brand']);
                if (!$brand) continue;
                
                // Create variations
                $variations = [
                    ['sku_suffix' => '', 'stock' => rand(5, 50)],
                    ['sku_suffix' => '-BOX', 'stock' => rand(3, 30)],
                    ['sku_suffix' => '-OEM', 'stock' => rand(2, 20)],
                ];
                
                foreach ($variations as $variation) {
                    if ($productCount >= 100) break;
                    
                    $sku = 'CPU-' . strtoupper(Str::random(8)) . $variation['sku_suffix'];
                    $productCode = 'PC-' . strtoupper(Str::random(10));
                    
                    // Vary prices slightly
                    $priceMultiplier = 1 + (rand(-5, 5) / 100);
                    $price = round($baseProduct['price'] * $priceMultiplier);
                    $salePrice = $baseProduct['sale_price'] ? round($baseProduct['sale_price'] * $priceMultiplier) : null;
                    
                    // Randomly change condition and warranty for variations
                    $conditions = ['new', 'used', 'refurbished'];
                    $condition = $variation['sku_suffix'] === '-OEM' ? 'new' : $conditions[array_rand($conditions)];
                    $hasWarranty = $condition === 'new' ? true : (rand(0, 1) === 1);
                    $warrantyMonths = $hasWarranty ? ($condition === 'new' ? 36 : ($condition === 'refurbished' ? 12 : rand(6, 24))) : null;
                    
                    $product = Product::create([
                        'name' => $baseProduct['name'] . ($variation['sku_suffix'] ? ' ' . str_replace('-', '', $variation['sku_suffix']) : ''),
                        'slug' => Str::slug($baseProduct['name'] . '-' . $productCount),
                        'sku' => $sku,
                        'product_code' => $productCode,
                        'category_id' => $cpuCategory->id,
                        'brand_id' => $brand->id,
                        'price' => $price,
                        'sale_price' => $salePrice,
                        'price_updated_at' => now()->subDays(rand(0, 30)),
                        'stock' => $variation['stock'],
                        'condition' => $condition,
                        'has_warranty' => $hasWarranty,
                        'warranty_months' => $warrantyMonths,
                        'description' => $baseProduct['description'],
                        'short_description' => substr($baseProduct['description'], 0, 100) . '...',
                        'specifications' => $baseProduct['specs'],
                        'is_active' => true,
                    ]);
                    
                    $productCount++;
                }
            }
            
            // If we still need more products, duplicate base products with different SKUs
            if ($productCount < 100) {
                // Add more variations
                continue;
            }
        }
        
        $this->command->info('Created 100 CPU products successfully!');
    }
}
