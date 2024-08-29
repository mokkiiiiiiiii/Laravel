<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ログイン時のバリデーションと処理
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // バリデーションの追加
        $request->validate([
            'email' => 'required|string|email',
            'password' => ['required','string','min:6'],
        ], [
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードは必須項目です。',
            'password.min' => 'パスワードは6文字以上で入力してください。',
        ]);
        // ログイン処理
        if ($this->attemptLogin($request)) {
            // ログイン成功後のリダイレクト
            return redirect()->intended($this->redirectPath());
        }

        // ログイン失敗時の処理
        return back()->withErrors([
            'email' => '認証に失敗しました。メールアドレスまたはパスワードが間違っています。',
        ])->withInput($request->only('email'));
        
    }

    /**
     * ログアウト後のリダイレクト先を設定
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loggedOut(Request $request)
    {
        return redirect('/login');  // ログアウト後にログインページにリダイレクト
    }
}
