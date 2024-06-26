@extends('layout')

@section('contents')
    @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
    @endif
    <h1>ログイン</h1>
        <form action="/login" method="post">
            @csrf
            @if(session('front.task_register_success') == true)
                ユーザを登録しました！！<br>
            @endif
            email:<input name="email" value="{{old('email')}}"><br>
            パスワード:<input name="password" type="password"><br>
            <button>ログインする</button><br>
            <a href="/user/register">会員登録</a>
        </form>

@endsection