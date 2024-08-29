<!DOCTYPE html>

<html>

<head>
<meta charset='utf-8"'>
<link rel='stylesheet' href='/css/app.css'>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  @extends('layouts.app')
  @section('content')

<div class='container'>
<h2 class='page-header'>新しく投稿する</h2>

{!! Form::open(['url' => 'post/create']) !!}

<div class="form-group">
{!! Form::input('text', 'newPost', null, ['required', 'class' => 'form-control', 'placeholder' => '投稿内容']) !!}

    @error('newPost')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-success pull-right">追加</button>

{!! Form::close() !!}

</div>

<footer>
<small>Laravel@crud.curriculum</small>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection
</body>
</html>
