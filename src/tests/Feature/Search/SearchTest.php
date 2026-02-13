<?php

namespace Tests\Feature\Search;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class SearchTest extends TestCase
{
    use RefreshDatabase;

//「商品名」で部分一致検索ができる
    public function test_guest_can_search_products_by_partial_title()
    {
        $seller = User::factory()->create();

        Product::factory()->for($seller)->create([
            'title' => '青いボール',
        ]);

        Product::factory()->for($seller)->create([
            'title' => '青い靴',
        ]);

        Product::factory()->for($seller)->create([
            'title' => '赤いボール',
        ]);
        $response = $this->get('/?keyword=青い');
        $response->assertOk();

        $response->assertSee('青いボール');
        $response->assertSee('青い靴');
        $response->assertDontSee('赤いボール');
    }

//検索状態がマイリストでも保持されている
    public function test_search_keyword_is_preserved_when_moving_to_mylist()
    {
        $seller = User::factory()->create();

        Product::factory()->for($seller)->create(['title' => 'テスト商品A']);
        Product::factory()->for($seller)->create(['title' => 'テスト商品B']);

        $response = $this->get('/?keyword=テスト');
        $response->assertOk();

        $response->assertSee('テスト商品A');

        $response->assertSee('tab=mylist');
        $keyword = 'テスト';
        $encoded = urlencode($keyword);

        $response->assertSee("keyword={$encoded}&amp;tab=mylist",false);
    }
}