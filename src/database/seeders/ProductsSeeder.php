<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductsSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products =[
            [
                'title' => '腕時計',
                'image' => 'images/Armani+Mens+Clock.jpg',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'condition' => 1,
            ],
            [
                'title' => 'HDD',
                'image' => 'images/HDD+Hard+Disk.jpg',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'condition' => 2,
            ],
            [
                'title' => '玉ねぎ3束',
                'image' => 'images/iLoveIMG+d.jpg',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ３束のセット',
                'price' => 300,
                'condition' => 3,
            ],
            [
                'title' => '革靴',
                'image' => 'images/Leather+Shoes+Product+Photo.jpg',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'condition' => 4,
            ],
            [
                'title' => 'ノートPC',
                'image' => 'images/Living+Room+Laptop.jpg',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'condition' => 1,
            ],
            [
                'title' => 'マイク',
                'image' => 'images/Music+Mic+4632231.jpg',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'condition' => 2,
            ],
            [
                'title' => 'ショルダーバッグ',
                'image' => 'images/Purse+fashion+pocket.jpg',
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'condition' => 3,
            ],
            [
                'title' => 'タンブラー',
                'image' => 'images/Tumbler+souvenir.jpg',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'condition' => 4,
            ],
            [
                'title' => 'コーヒーミル',
                'image' => 'images/Waitress+with+Coffee+Grinder.jpg',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'condition' => 1,
            ],
            [
                'title' => 'メイクセット',
                'image' => 'images/外出メイクアップセット.jpg',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'condition' => 2,
            ],
            ];
            foreach ($products as $product) {
                Product::create([
                    ...$product,//...は配列展開のPHPスプレッド構文
                    'user_id' => User::inRandomOrder()->value('id'),
                    ]);
            }
}
}
