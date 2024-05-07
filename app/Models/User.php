<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

// ユーザーの権限を示すenum
enum UserRole: int
{
    use \App\Traits\Enum\EnumToArray; // enumの情報を配列として扱うためのtraits

    case Normal = 0;
    case Admin = 1;
}

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
    ];

    public function isAdmin()
    {
        return $this->role == UserRole::Admin;
    }

    // 管理者から新規ユーザーを作成する特殊なメソッド。
    // 作成されたユーザーはemailの認証が済んだ状態になる。
    public static function createAsVerified($attributes) {
        $user = new User();

        //　通常許可しない email_verified_at や remember_token を管理者用ロジックから直接書き換えるため一時的にガードを外す
        User::unguard(); 
        $user->updateAttributes([
            ...$attributes, 
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ]);
        User::reguard();

        return $user;
    }

    public function updateAttributes($attributes) {
        if(isset($attributes['password'])) {
            $this->fill($attributes);
            $this->setPassword($attributes['password']);
        } else {
            unset($attributes['password']);
            $this->fill($attributes);
        }

        $this->save();
    }

    private function setPassword($password) {
        $this->attributes['password'] = bcrypt($password);
    }
}
