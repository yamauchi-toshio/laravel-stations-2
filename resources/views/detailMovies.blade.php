<!DOCTYPE html>
<html lang="en">

@if(session('message'))
	<div>
		{{ session('message') }}
	</div>
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザー：映画詳細(detailMovies)</title>
</head>

<div class="container small">
  <h1>ユーザー：映画詳細</h1>
  <h3>(movie/{id})</h3>

    <div>
        〇映画情報
        <table border="2" bordercolor=blue>
            <tr>
                <th>Movie_ID</th>
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
{{--   
                <th>{{ $movie->created_at }}</th>
                <th>{{ $movie->updated_at }}</th>
--}}
            </tr>
        </table>
        <br><br>

        〇上映スケジュール
        <table border="2" bordercolor=green>
            <tr>
                <th>Schedule_ID</th>
                <th>MovieID</th>
                <th>上映開始時刻</th>
                <th>上映終了時刻</th>
                <th>座席を予約する</th>
            </tr>

            @foreach ($Schedules as $Schedule)
            <tr>
                <th>{{ $Schedule->id }}</th>
                <th>{{ $Schedule->movie_id }}</th>
                <th>{{ $Schedule->start_time }}</th>
                <th>{{ $Schedule->end_time }}</th>
{{--                
                <td><a href="{{ route('reserve', ['m_id'=>$Schedule->movie_id , 's_id'=>$Schedule->id]) }}" class="btn btn-info">座席を予約する</a></td>
--}}                
                <td>
                    <form action="{{ route('reserve', ['m_id'=>$Schedule->movie_id , 's_id'=>$Schedule->id]) }}" method="get">
                        <input type = "hidden" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
                        <input type = "hidden" type="text" name="screen_no" value="{{ $Schedule->screen_no }}" >
                        <button type="submit">座席を予約する</button>
                    </form>
                </td>       
            </tr>
            @endforeach
        </table>
    </div>

</div>
