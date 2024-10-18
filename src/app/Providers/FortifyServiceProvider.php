<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // ログイン画面の設定
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Fortifyの登録画面表示は削除して、RegisterControllerに任せる

        // ログイン処理に LoginRequest を使用
        Fortify::authenticateUsing(function (LoginRequest $request) {
            // LoginRequest によるバリデーションは自動で行われる

            // ユーザーをメールアドレスで検索
            $user = User::where('email', $request->email)->first();

            // ユーザーが存在し、パスワードが一致する場合ログイン成功
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
            // ログイン失敗時、エラーメッセージをセッションに追加してリダイレクト
            session()->flash('message', 'メールアドレスまたはパスワードが正しくありません');

            return null;   // 認証失敗時はnullを返す
        });

        // ログインリクエストに対するレート制限
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });
    }
}
