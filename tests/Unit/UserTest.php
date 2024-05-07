<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_is_admin_false_for_normal()
    {
        $user = User::factory()->make();
        $this->assertFalse($user->isAdmin());
    }

    public function test_is_admin_true_for_admin()
    {
        $user = User::factory()->make(['role' => 1]);
        $this->assertTrue($user->isAdmin());
    }

    public function test_createAsVerified() {
        $attributes = [...User::factory()->make()->attributesToArray(), 'password' => 'password'];

        $user = User::createAsVerified($attributes);
        
        $this->assertTrue($user->exists);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNotNull($user->remember_token);
    }

    public function test_updateAttributes_not_having_password() {
        $user = User::factory()->create();
        $before_password = $user->password;
        $attributes = [...User::factory()->make()->attributesToArray()];

        $user->updateAttributes($attributes);
        
        $this->assertEquals($attributes['name'], $user->name);
        $this->assertEquals($before_password, $user->password); // パスワードは変わっていない
    }    

    public function test_updateAttributes_having_password() {
        $user = User::factory()->create();

        $attributes = [...User::factory()->make()->attributesToArray(), 'password' => 'newPassword'];

        $user->updateAttributes($attributes);
        
        $this->assertEquals($attributes['name'], $user->name);
        $this->assertNotEquals(bcrypt('newPassword'), $user->password); // パスワードは変わる
    }    
}
