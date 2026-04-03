<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => '經典皮革錶帶手錶', 'price' => 3200, 'stock' => 20, 'category' => '配件',
             'description' => '簡約設計，適合日常佩戴。',
             'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600'],
            ['name' => '北歐風陶瓷馬克杯', 'price' => 680, 'stock' => 50, 'category' => '居家',
             'description' => '手工製作，溫潤質感。',
             'image' => 'https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=600'],
            ['name' => '極簡帆布托特包', 'price' => 1200, 'stock' => 30, 'category' => '包款',
             'description' => '耐用帆布材質，日常必備。',
             'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600'],
            ['name' => '香氛蠟燭禮盒組', 'price' => 890, 'stock' => 40, 'category' => '居家',
             'description' => '天然植物蠟，淡雅香氣。',
             'image' => 'https://images.unsplash.com/photo-1602028915047-37269d1a73f7?w=600'],
            ['name' => '復古圓框太陽眼鏡', 'price' => 1580, 'stock' => 25, 'category' => '配件',
             'description' => '經典復古造型，UV400防護。',
             'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600'],
            ['name' => '純棉簡約白色T恤', 'price' => 590, 'stock' => 100, 'category' => '服飾',
             'description' => '100%純棉，舒適透氣。',
             'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600'],
            ['name' => '旅行用護照夾', 'price' => 750, 'stock' => 35, 'category' => '配件',
             'description' => '真皮材質，多卡槽設計。',
             'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600'],
            ['name' => '木質藍牙音箱', 'price' => 2800, 'stock' => 15, 'category' => '電子',
             'description' => '溫潤木質外殼，高音質輸出。',
             'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
