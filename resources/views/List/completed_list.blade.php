@extends('layout')

@section('contents')
        <h1>購入済み「買うもの」一覧</h1>
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <a href="/shopping_list/list">「買うもの」一覧に戻る</a><br>
        <table border="1">
        <tr>
            <th>「買うもの」名
            <th>購入日
        @foreach($list as $data)
            <tr>
                <td>{{ $data->name }}
                <td>{{$data->created_at->format('Y/m/d')}}


        @endforeach
        </table>
        現在{{$list->currentpage()}}ページ目<br>
        @if($list->onFirstPage()===false)
            <a href="/shopping_list/list">最初のページ</a>
        @else
            最初のページ
        @endif/
        @if($list->previousPageUrl()!==null)
            <a href="{{$list->previouspageurl()}}">前に戻る</a>
        @else
            前に戻る
        @endif/
        @if($list->nextPageUrl()!==null)
            <a href="{{$list->nextpageurl()}}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <menu>
            <a href="/logout">ログアウト</a><br>
        </menu>
@endsection
