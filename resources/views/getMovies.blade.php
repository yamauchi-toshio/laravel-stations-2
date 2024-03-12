<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者：映画一覧(getMovies)</title>
</head>
<body>
    <script>

    </script>
    <h1>管理者：映画一覧</h1>
    <h3>(index2:admin/movies)</h3>

    <table border="10" bordercolor=green>
        <tr>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
{{--
            <th>登録日時</th>
            <th>更新日時</th>
--}}
            <th>編集</th>
            <th>削除</th>
            <th>詳細</th>
        </tr>

        @foreach ($movies as $movie)
        <tr>
            <th>{{ $movie->id }}</th>
            <th>{{ $movie->title }}</th>
            <th>{{ $movie->image_url }}</th>
            <th>{{ $movie->published_year }}</th>
            @if( $movie->is_showing ==1 )
                <th>上映中</th>
            @else
                <th>上映予定</th>
            @endif
<!--
            <th>{{ $movie->is_showing }}</th>
-->
            <th>{{ $movie->description }}</th>
{{--
            <th>{{ $movie->created_at }}</th>
            <th>{{ $movie->updated_at }}</th>
--}}
            <td><a href="{{ route('edit', ['id'=>$movie->id]) }}" class="btn btn-info">編集</a></td>       
            <td>
                <form action="{{ route('destroy', ['id'=>$movie->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>                
            </td>
            <td><a href="{{ route('admindetail', ['id'=>$movie->id]) }}" class="btn btn-info">詳細</a></td>
        </tr>
        @endforeach
    </table>

</body>
</html>