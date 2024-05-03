@extends('layout')

@section('contents')
        <h1>「買うもの」の登録</h1>
        @if(session('front.task_register_success') ==true)
            「買うもの」を登録しました！！<br>
        @endif
        @if (session('front.task_delete_success') == true)
            「買うもの」を削除しました！！<br>
        @endif
        @if(session('front.task_completed_success') == true)
            「買うもの」を完了にしました！！<br>
        @endif
        @if(session('front.task_completed_failure') == true)
            「買うもの」の完了に失敗しました。<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/shopping_list/register" method="post">
        @csrf
        「買うもの」名:<input name="name" value="{{old('name')}}"><br>
        <button>「買うもの」を登録する</button>
        </form>
        <h1>「買うもの」一覧</h1>
        <a href="/completed_shopping_list/list">購入済み「買うもの」一覧</a>
        <table border="1">
            <tr>
                <th>登録日
                <th>「買うもの」名
            </tr>
        @foreach($list as $data)
            <tr>
                <td>{{ $data->created_at->format('Y/m/d') }}
                <td>{{ $data->name }}
                <td><form style="margin: 0px;" action="{{route('complete',['shopping_list_id'=>$data->id])}}" method="post">
                        @csrf
                        <button onclick='return confirm("この「買うもの」を「完了」します。よろしいですか？");'>完了</button>
                    </form>
                </td>
                <td>　</td>
                <td><form style="margin: 0px;" action="{{route('delete',['shopping_list_id'=>$data->id])}}" method="post">
                        @csrf
                        @method("DELETE")
                        <button onclick='return confirm("この「買うもの」を「削除」します。よろしいですか？");'>削除</button>
                    </form>
                </td>
            </tr>

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
