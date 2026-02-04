<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    //メールアドレスが入力されていない場合、バリデーションメッセージが表示される
        public function test_login_requires_email()
        {
            $data =[
                'password' => 'password',
            ];
            $response = $this->from('/login')->post('/login',$data);
            $response->assertRedirect('/login');
            $response->assertSessionHasErrors([
                'email'=>'メールアドレスを入力してください',
            ]);
        }

    //パスワードが入力されていない場合、バリデーションメッセージが表示される
        public function test_login_requires_password()
        {
            $data =[
                'email' => 'testuser@example.com',
            ];
            $response = $this->from('/login')->post('/login',$data);
            $response->assertRedirect('/login');
            $response->assertSessionHasErrors([
                'password'=>'パスワードを入力してください',
                ]);
        }

    //入力情報が間違っている場合、バリデーションメッセージが表示される
        public function test_user_did_not_register()
        {
            $user = [
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
            ];
            $response = $this->post('/login', $user);
            $response->assertSessionHasErrors([
                'password' => 'ログイン情報が登録されていません'
            ]);
            $response->assertRedirect('/');
        }

    //正しい情報が入力された場合、ログイン処理が実行される
        public function test_user_can_login_with_valid_credentials()
        {
            $user = User::factory()->create([
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
            ]);
            $response = $this->post('/login',
                [
                    'email' => 'user@example.com',
                    'password' => 'password',
                ]
            );

            $response->assertRedirect('/');
            $this->assertAuthenticatedAs($user);
        }
}