<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>一覧(スケジュール)</title>
</head>
<body>
    <script>

    </script>
    <h1>一覧(スケジュール)</h1>

    <div>

    <table border="3" bordercolor=green>
        <tr>
            <th>ID</th>
            <th>MovieID</th>
            <th>映画タイトル</th>
            <th>上映開始時刻</th>
            <th>上映終了時刻</th>
            <th>詳細</th>

        </tr>

        @foreach ($schedules as $schedule)
        <tr>
            <th>{{ $schedule->id }}</th>
            <th>{{ $schedule->movie_id }}</th>
            <th>{{ $schedule->title }}</th>
            <th>{{ $schedule->start_time }}</th>
            <th>{{ $schedule->end_time }}</th>
            <td><a href="{{ route('adminSchedule', ['id'=>$schedule->id]) }}" class="btn btn-info">詳細</a></td>
        </tr>
        @endforeach
    </table>
    </div>
</body>
</html>