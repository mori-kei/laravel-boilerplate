<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ------------------------------
// 1つずつのエンドポイントを定義する方式
Route::get('/', function () {
    return view('welcome'); // 動作するロジックをここに直接書くこともできるが、あまり多くは使われない
})->name('home');

// エンドポイントに対応したControllerのメソッドを定義する方式
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ------------------------------
// 階層的に、かつ複数のエンドポイントを定義する方式
Route::middleware(['auth', 'ensureAdmin']) // 適用したいMiddleware名（ app/Http/Kernel.phpで定義 ）
    ->prefix('admin') // URLの接頭辞として使われる（ ex. http://localhost:3000/admin/users ）
    ->name('admin.') // 名前付きrouteでURLを呼び出すときの接頭辞（ ex. route('admin.users.index') ）
    ->group(function () {
        Route::resource('/users', UserController::class); // Admin/UserControllerの決められた名前のメソッドに一気に関連づく
    });
