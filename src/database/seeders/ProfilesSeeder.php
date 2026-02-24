<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfilesSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
        [
            'name' => 'テスト 太郎',
            'post_code' => '105-0011',
            'image' => 'images/東京タワー.jpg',
            'address' => '東京都港区芝公園4-2-8'
        ],
        [
            'name' => 'テスト 花子',
            'post_code' => '100-0005',
            'address' => '東京都千代田区丸の内1-9-1',
            'image' => 'images/東京駅.jpg'
        ],
    ];

        foreach ($profiles as $data) {
            $userId = User::whereDoesntHave('profile')
                ->inRandomOrder()
                ->value('id');

            if (! $userId) {
                break; 
            }

            Profile::create(array_merge($data, [
                'user_id' => $userId,
            ]));
        }
    }
}
