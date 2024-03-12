<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者:スケジュール登録(createSchedules)</title>
</head>

<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif    
    <!-- フォームエリア -->
    <h1>管理者:スケジュール登録</h1>
    <h3>(/admin/movies/{id}/schedules/create)</h3>

    <form method="post" action="/admin/movies/' . ['id'=>$movie->id] . '/schedules/store">

        {{ csrf_field() }}

         <!-- フラッシュメッセージ -->
         @if (session('flash_message'))
            <div>
                {{ session('flash_message') }}
            </div>
        @endif
        <h2>[ID]：{{ $movie->id }}　[映画タイトル]：{{ $movie->title }}</h2>

        <input name="movie_id" value = {{ $movie->id }} type = "hidden">
        <input name="movie_title" value = {{ $movie->title }} type = "hidden">
        
        上映開始時刻:
        <br>
            <input type="date" name="start_time_date" value = '2024-03-30'>
            <input type="time" name="start_time_time" value = '10:00'>
        <br>
        上映終了時刻:
        <br>
            <input type="date" name="end_time_date" value = '2024-03-30'>
            <input type="time" name="end_time_time" value = '12:00'>
        <br>
        スクリーン:
        <br>
        <select class="form-control" id="screen_no" name="screen_no">
            <option value="1">スクリーン1</option>
            <option value="2">スクリーン2</option>
            <option value="3">スクリーン3</option>
        </select>
        <br>
        <br>
        <div>
            <input type="submit" value="登録">
        </div>

    </form>

    <br><br>
    <table border="2" bordercolor=green>
        <tr>
            <th>ID</th>
            <th>MovieID</th>
            <th>上映開始時刻</th>
            <th>上映終了時刻</th>
            <th>スクリーンNo</th>
            <th>編集</th>
            <th>削除</th>
        </tr>

        @foreach ($Schedules as $Schedule)
        <tr>
            <th>{{ $Schedule->id }}</th>
            <th>{{ $Schedule->movie_id }}</th>
            <th>{{ $Schedule->start_time }}</th>
            <th>{{ $Schedule->end_time }}</th>
            <th>{{ $Schedule->screen_no }}</th>
            <td><a href="{{ route('editSchedule', ['id'=>$Schedule->id]) }}" class="btn btn-info">編集</a></td>       
            <td>
{{--                
                <form action="{{ route('admindestroySheet', ['id'=>$Schedule->id]) }}" method="POST">
--}}
                <form action="{{ route('destroySchedule', ['id'=>$Schedule->id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>                
            </td>
        </tr>
        @endforeach
    </table>
    </div>
</body>
</html>