<!DOCTYPE html>

<html>
  <body>
    @extends('layouts.app')
    @section('content')

    <div class='container'>
      <p class="pull-right"><a class="btn btn-success" href="/create-form">投稿する</a></p>

      <form action="{{ route('posts.search') }}" method="GET">
    <input type="text" name="keyword" placeholder="検索キーワード" value="{{ request('keyword') }}">
    <button type="submit">検索</button>
</form>

      <h2 class='page-header'>投稿一覧</h2>
        @if (isset($message))
          <p>{{ $message }}</p>
        @else
      <table class='table table-hover'>
        <tr>
          <th>名前</th>
          <th>投稿内容</th>
          <th>投稿日時</th>
        </tr>
          @foreach ($lists as $list)
        <tr>
          <td>{{ $list->user_name }}</td>
          <td>{{ $list->contents }}</td>
          <td>{{ $list->created_at }}</td>

          <!-- ログインユーザーが投稿の所有者の場合のみ、更新・削除ボタンを表示 -->

          @if ($list->user_id === Auth::id())
          <td><a class="btn btn-primary" href="/post/{{ $list->id }}/update-form">更新</a></td>
          <td>
            <a class="btn btn-danger" href="/post/{{ $list->id }}/delete"
            onclick="return confirm('こちらの投稿を削除してもよろしいでしょうか？')">削除</a>
          </td>

          @endif
        </tr>
          @endforeach
      </table>
      @endif
    </div>
    @endsection
  </body>
</html>
