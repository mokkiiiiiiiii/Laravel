<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostsController extends Controller
{

  public function __construct()
    {
    $this->middleware('auth');
    }

  public function index()
  {
    $list = DB::table('posts')->get();
    return view('posts.index',['lists'=>$list]);
  }  //

  public function createForm()
  {
    return view('posts.createForm');
  }

  public function create(Request $request)
  {
    $request->validate([
      'newPost' => [
            'required',
            'string',
            'max:100',
            function ($attribute, $value, $fail) {
                if (preg_match('/^\s*$/u', $value)) {
                    $fail('投稿内容には空白以外の文字を含めてください。');
                }
                if (!preg_match('/[^\x20-\x7e]/u', $value)) {
                    $fail('投稿内容には半角文字のみを使用することはできません。');
                }
            },
        ],
      ], [
        'newPost.required' => '投稿内容は必須項目です。',
        'newPost.max' => '投稿内容は100文字以内で入力してください。',
    ]);

    $post = $request->input('newPost');

    DB::table('posts')->insert([
    'contents' => $post,
    'user_name' => Auth::user()->name,
    'user_id' => Auth::id(),
    'created_at' => now(),
    'updated_at' => now(),
    ]);
    return redirect('/index');
  }

  public function updateForm($id)
  {
    $post = DB::table('posts')
    ->where('id', $id)
    ->first();
    return view('posts.updateForm', ['post' => $post]);
  }

  public function update(Request $request)
  {
  $id = $request->input('id');

  // バリデーションの追加
    $request->validate([
        'upPost' => [
            'required',
            'string',
            'max:100',
            function ($attribute, $value, $fail) {
                // 空白文字のみの入力を無効にする
                if (preg_match('/^\p{Zs}+$/u', $value) || preg_match('/^\s*$/u', $value)) {
                    $fail('投稿内容には空白以外の文字を含めてください。');
                }
            },
        ],
    ], [
        'upPost.required' => '投稿内容は必須項目です。',
        'upPost.max' => '投稿内容は100文字以内で入力してください。',
        'upPost.regex' => '投稿内容には空白以外の文字を含めてください。',
    ]);

  $up_post = $request->input('upPost');

  $post = DB::table('posts')->where('id', $id)->first();
  // ログインユーザーが投稿の作成者であるか確認
    if ($post->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');  // 権限がない場合は403エラー
    }

  DB::table('posts')
  ->where('id', $id)
  ->update(
  ['contents' => $up_post]
  );
  return redirect('/index');
  }

  public function delete($id)
  {
  $post = DB::table('posts')->where('id', $id)->first();
  // ログインユーザーが投稿の作成者であるか確認
    if ($post->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');  // 権限がない場合は403エラー
    }

  DB::table('posts')
  ->where('id', $id)
  ->delete();

  return redirect('/index');
  }

  public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // キーワードが入力されている場合のみ検索を実行
        $lists = Post::where('contents', 'LIKE', '%' . $keyword . '%')->get();

        if ($lists->isEmpty()) {
        return view('posts.index', ['message' => '検索結果は0件です。']);
        }

        // 検索結果をビューに渡す
        return view('posts.index', ['lists' => $lists]);
    }
}
