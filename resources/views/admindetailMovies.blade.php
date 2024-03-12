<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> 管理者：映画詳細(admindetailMovies)</title>
</head>

<!-- フラッシュメッセージ -->
@if (session('flash_message'))
    <div>
        {{ session('flash_message') }}
    </div>
@endif

<div class="container small">
  <h1>管理者：映画詳細</h1>
  <h3>(admindetail:admin/movies/{id})</h3>

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

        〇スケジュール
        <table border="2" bordercolor=green>
            <tr>
                <th>ID</th>
                <th>MovieID</th>
                <th>上映開始時刻</th>
                <th>上映終了時刻</th>
                <th>スクリーンNo</th>
                <th>詳細</th>
                <th>座席を予約する</th>
            </tr>

            @foreach ($schedules as $schedule)
            <tr>
                <th>{{ $schedule->id }}</th>
                <th>{{ $schedule->movie_id }}</th>
                <th>{{ $schedule->start_time }}</th>
                <th>{{ $schedule->end_time }}</th>
                <th>{{ $schedule->screen_no }}</th>
                <td><a href="{{ route('adminSchedule', ['id'=>$schedule->id]) }}" class="btn btn-info">詳細</a></td>

                <td>
                    <table border="3" bordercolor=green>
                        <tr>
                            <th colspan="5">スクリーン</th>
                        </tr>
                        @foreach ($sheets as $sheet)
                            @if( $sheet->screen_no == $schedule->screen_no )
                                @if( $sheet->column == 1 )
                                    <tr>
                                @endif
                                <th>
                                    <form action="{{route('adminreservecreate')}}" method="get">
                                        <input type = "hidden" type="text" name="movie_id" value="{{ $schedule->movie_id  }}" >
                                        <input type = "hidden" type="text" name="schedule_Id" value="{{ $schedule->id  }}" >
                                        <input type = "hidden" type="text" name="sheet_Id" value="{{ $sheet->id }}" >
                                        <input type = "hidden" type="text" name="sheetname" value="{{ $sheet->row }}-{{ $sheet->column }}" >
                                        <input type = "hidden" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
                                        <button type="submit">{{ $sheet->row }}-{{ $sheet->column }}</button>
                                    </form>
                                </th>
                                @if( $sheet->column == 5 )
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                <td>
            </tr>
            @endforeach
        </table>
    </div>

</div>
