<?php

namespace Tests\Feature\Information;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Profile;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

//変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
    public function test_user_can_see_profile()
    {
        $user = User::factory()->create();
        $profile=Profile::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();

        $response->assertSee('value="'.$profile->name.'"', false);
        $response->assertSee('value="'.$profile->post_code.'"', false);
        $response->assertSee('value="'.$profile->address.'"', false);

        $response->assertSee('/storage/profiles/', false);

    }

}