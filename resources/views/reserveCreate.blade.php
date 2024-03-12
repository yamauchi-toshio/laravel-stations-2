<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザー:予約フォーム</title>
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
    <script>

    </script>
    <h1>ユーザー：座席予約フォーム</h1>
    <h3>(/reservations/create)</h3>
    <br>

    <div>
        〇映画
        <br>
        <table border="2" bordercolor=blue>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
            </tr>
            <tr>
                <th>{{ $movie->id }}</th>
                <th>{{ $movie->title }}</th>
            </tr>
        </table>

        〇上映時間
        <br>
        <table border="2" bordercolor=blue>
            <tr>
                <th>ID</th>
                <th>上映日(S)</th>
                <th>開始時間</th>
                <th>上映日(E)</th>
                <th>終了時間</th>
            </tr>
            <tr>
                <th>{{ $schedule->id }}</th>
                <th>{{ $schedule->start_time_date }}</th>
                <th>{{ $schedule->start_time_time }}</th>
                <th>{{ $schedule->end_time_date }}</th>
                <th>{{ $schedule->end_time_time }}</th>
            </tr>
        </table>

        〇座席
        <br>
        <table border="2" bordercolor=blue>
            <tr>
{{--                
                <th>座席ID</th>
--}}
                <th>座席</th>
            </tr>
            <tr>
{{--                
                <th>{{ $request->sheetId }}</th>
--}}
                <th>{{ $request->sheetname }}</th>
            </tr>
        </table>

        <br><br>
        <form action="{{ route('storesheet') }}" method="post">
            {{ csrf_field() }}
            <fieldset>
                <input type = "hidden" type="text" name="movie_id" value="{{ $movie->id }}" >
                <input type = "hidden" type="text" name="schedule_id" value="{{ $schedule->id }}" >
                <input type = "hidden" type="text" name="sheet_id" value="{{ $request->sheetId }}" >
                <input type = "hidden" type="text" name="date" value="{{ $request->date }}" >
                <input type = "hidden" type="text" name="screen_no" value="{{ $request->screen_no }}" >
                <div class="form-group">
                    <!--名前 -->
                    <label for="name">{{ __('予約者名') }}</label>
                    <input type="text" class="form-control" name="name" id="name" value = ''>
                    <br>
                    <!--メールアドレス -->
                    <label for="mail">{{ __('メールアドレス') }}</label>
                    <input type="text" class="form-control" name="email" id="email" value = ''>
                </div>

                <div class="d-flex justify-content-between pt-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('登録') }}
                    </button>
                </div>
            </fieldset>
        </form>

    </div>
</body>
</html>