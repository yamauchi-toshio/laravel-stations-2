<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザー：座席予約(reserveSheets)</title>
</head>

@if(session('message'))
	<div>
		{{ session('message') }}
	</div>
@endif

<body>
    <script>

    </script>
    <h1>ユーザー：座席予約</h1>

    <div>
        〇映画
        <br>
        <table border="2" bordercolor=blue>
            <tr>
                <th>ID</th>
                <th>映画タイトル</th>
                <th>画像URL</th>
                <th>公開年</th>
                <th>上映中かどうか</th>
                <th>概要</th>
                <th>ジャンル</th>                
                <th>登録日時</th>
                <th>更新日時</th>
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

                <th>{{ $movie->created_at }}</th>
                <th>{{ $movie->updated_at }}</th>

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

        〇座席選択
        <br>
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
                        <form action="{{route('reservecreate', ['m_id'=>$movie->id, 's_id'=>$schedule->id])}}" method="get">
                            <input type = "hidden" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
                            <input type = "hidden" type="text" name="sheetId" value="{{ $sheet->id }}" >
                            <input type = "hidden" type="text" name="sheetname" value="{{ $sheet->row }}-{{ $sheet->column }}" >
                            <input type = "hidden" type="text" name="screen_no" value="{{ $schedule->screen_no }}" >
                            <button type="submit">{{ $sheet->row }}-{{ $sheet->column }}</button>
                        </form>
                    </th>
                    @if( $sheet->column == 5 )
                        </tr>
                    @endif
                @endif
                @endforeach
        </table>



        <br><br>
        /////////////////////////////////////////////////////
        <br>
        　　　確認用表示 (本来表示必要なし)
        <br>
        /////////////////////////////////////////////////////
        <br>
        〇予約一覧
        <table border="3" bordercolor=green>
            <tr>
                <th>ID</th>
                <th>日付</th>
                <th>スケジュールID</th>
                <th>シートID</th>
                <th>シート</th>
                <th>Mail</th>
                <th>名前</th>
{{--                
                <th>キャンセル</th>
--}}
            </tr>
            
            @foreach ($reservations as $reservation)
            <tr>
                <th>{{ $reservation->id }}</th>
                <th>{{ $reservation->date }}</th>
                <th>{{ $reservation->schedule_id }}</th>
                <th>{{ $reservation->sheet_id }}</th>
                <th>{{ strtoupper($reservation->sheet->row.$reservation->sheet->column) }}</th>
                <th>{{ $reservation->email }}</th>
                <th>{{ $reservation->name }}</th>
{{--                
                @if( $reservation->is_canceled ==1 )
                    <th>済</th>
                @else
                    <th>未</th>
                @endif
--}}
            </tr>
            @endforeach
        </table>


    </div>
</body>
</html>