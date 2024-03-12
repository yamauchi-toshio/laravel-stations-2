<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規登録画面</title>
</head>

<body>
    <!-- フォームエリア -->
    <h2>映画登録フォーム</h2>
    <form method="post" action="/admin/movies/store">
        {{ csrf_field() }}

         <!-- フラッシュメッセージ -->
         @if (session('flash_message'))
            <div>
                {{ session('flash_message') }}
            </div>
        @endif

        映画タイトル:
        <br>
            <input name="title" value="タイトル">
        <br>

        画像URL:
        <br>
            <input name="image_url" value="https://www.yahoo.co.jp/">
        <br>
    
        公開年:
        <br>
            <input name="published_year" value="200">
        <br>

        公開中かどうか:
        <br>
            <input name="is_showing" type="hidden" value="0">
            <input name="is_showing" type="checkbox" value=true checked>上映中         
        <br>

        概要:
        <br>
            <textarea name="description">概要</textarea>
        <br>

        ジャンル:
        <br>
            <input name="genre" value="ジャンル">
        <br>
<!--
        登録日時:
        <br>
            <input name="created_at">
        <br>

        更新日時:
        <br>
            <input name="updated_at">
        <br>
-->        
        <br>
        <div>
            <input type="submit" value="送信">
        </div>

    </form>

    <br><br>

    <div>
    <table border="5">
        <tr>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>ジャンル</th>
{{--            
            <th>登録日時</th>
            <th>更新日時</th>
--}}
        </tr>

        @foreach ($movies as $movie)
        <tr>
            <th>{{ $movie->id }}</th>
            <th>{{ $movie->title }}</th>
            <th>{{ $movie->image_url }}</th>
            <th>{{ $movie->published_year }}</th>
            @if( $movie->is_showing == 1 )
                <th>上映中</th>
            @else
                <th>上映予定</th>
            @endif
            <th>{{ $movie->description }}</th>
            <th>{{ $movie->genre_id }}</th>
{{--
            <th>{{ $movie->created_at }}</th>
            <th>{{ $movie->updated_at }}</th>
--}}
        </tr>
        @endforeach
    </table>    
    </div>
</body>
</html>