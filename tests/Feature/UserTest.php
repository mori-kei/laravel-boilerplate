<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_returns_a_successful_response_for_admin()
    {
        $this->seed('UserSeeder'); // UserSeeder を動かしてからテスト
        Sanctum::actingAs(User::first()); // 1番は管理者

        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/users');

        $response->assertStatus(200);
        $json = $response->decodeResponseJson();

        $this->assertEquals(3, count($json)); // Seederで入った3人分のデータが取得できている
    }

    public function test_users_returns_a_fobidden_response_for_user()
    {
        Sanctum::actingAs(User::factory()->create()); // 一般ユーザー

        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/users');
        $response->assertStatus(403);
    }

    public function test_user_returns_a_successful_response()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/user');
        $response->assertStatus(200)->assertJson($user->toArray());
    }

    public function test_user_returns_a_failure_response_on_not_logged_in()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/user');
        $response->assertStatus(401);
    }
}
