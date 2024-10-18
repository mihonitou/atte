<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    // 登録画面の表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ユーザー登録処理 (メソッド名を store に変更)
    public function store(RegisterRequest $request)
    {
        // ユーザーを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ユーザーをログインさせる（必要に応じて）
        Auth::login($user);

        // 登録完了メッセージを添えてリダイレクト
        return redirect('/register')->with('message', '会員登録が完了しました');
    }
}
