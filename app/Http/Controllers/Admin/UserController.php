<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug("### UserController#index ###"); // この内容は `storage/logs/laravel.log` のログに出ます。

        $users = User::all();
        return view('admin.users.index', compact('users'));
        // return view('admin.users.index', ['users' => $users]); // これと同じ意味になる
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        return view('admin.users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // @see https://laravel.com/docs/9.x/validation#quick-writing-the-validation-logic
        $validated = $request->validate([
            'name' => 'required|max:10',
            'email' => 'required|unique:users',
            'password' => 'required|regex:/^[1-9a-zA-Z!@_]+$/|min:8',
            'role' => 'required'            
        ]);

        $user = User::createAsVerified($validated);

        return to_route('admin.users.show', $user)->with('success', 'ユーザーを作成しました');
        // return redirect()->route('admin.users.show', $user); // これと同じ意味になる
    }

    /**
     * /admin/users/{id}
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // User型の指定によりDIでidから検索した結果が取れる。
        // show($id) のように型指定がなければidの数値。
        // 暗に以下のようなコードが呼ばれている。
        // $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // @see https://laravel.com/docs/9.x/validation#quick-writing-the-validation-logic
        $validated = $request->validate([
            'name' => 'required|max:10',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|regex:/^[1-9a-zA-Z!@_]+$/|min:8',
            'role' => 'nullable'
        ]);

        $user->updateAttributes($validated);

        return to_route('admin.users.show', ['user' => $user->id])->with('success', "{$user->name}を更新しました");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('admin.users.index')->with('success', "{$user->name}を削除しました");
    }
}
