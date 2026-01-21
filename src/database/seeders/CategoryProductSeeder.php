<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Supports\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapping=[
            '腕時計' => ['ファッション','メンズ'],
            'HDD' => ['家電'],
            '玉ねぎ3束' => [],
            '革靴' => ['ファッション','メンズ'],
            'ノートPC' => ['家電'],
            'マイク' => ['家電'],
            'ショルダーバッグ' => ['ファッション','レディース'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['コスメ'],
        ];

        foreach($mapping as $productTitle => $categoryNames) {
            $product = Product::where('title', $productTitle)->first();
            $categoryIds = Category::whereIn('name', $categoryNames)->pluck('id');

            if (! $product) {
                continue;
            }

            // 「カテゴリなし」
            $product->categories()->sync($categoryIds);
        }
    }
}
