<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者:スケジュール詳細画面(adminSchedules)</title>
</head>

<div class="container small">
  <h1>管理者:スケジュール詳細画面</h1>
  <h3>(/admin/schedules/{id})</h3>

    <div>
        <table border="2" bordercolor=green>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中かどうか</th>
                <th>概要</th>
                <th>ジャンル</th>
            </tr>

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
                <th>{{ $movie->description }}</th>
                <th>{{ $movie->genre_id }}</th>
            </tr>
        </table>

        <br><br>
        <a href="{{ route('createSchedule', ['id'=>$movie->id]) }}" class="btn btn-info">スケジュール登録</a>
        <br><br>

        <table border="2" bordercolor=green>
            <tr>
                <th>ID</th>
                <th>MovieID</th>
                <th>上映開始時刻</th>
                <th>上映終了時刻</th>
            </tr>

            <tr>
                <th>{{ $schedule->id }}</th>
                <th>{{ $schedule->movie_id }}</th>
                <th>{{ $schedule->start_time }}</th>
                <th>{{ $schedule->end_time }}</th>
            </tr>
        </table>
    </div>

</div>
