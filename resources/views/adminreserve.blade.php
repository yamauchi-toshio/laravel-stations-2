<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理者：予約一覧</title>
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
    <h1>管理者：予約一覧</h1>
    <br>

    <div>
        〇予約一覧
        <br>
        <table border="2" bordercolor=blue>
            <tr>
                <th>スケジュールID</th>
                <th>上映終了時間</th>
                <th>スクリーンNo</th>
                <th>座席</th>
                <th>座席名</th>
                <th>予約日時</th>
                <th>名前</th>
                <th>メールアドレス</th>
{{--
                <th>座席を予約する</th>
--}}                
                <th>編集</th>
                <th>削除</th>
            </tr>
            
            @foreach ($reservations as $reservation)
                @if( empty($reservation->schedule->end_time) )
                @else
                    <tr>
                        <th>{{ $reservation->schedule_id }}</th>      
                        <th>{{ $reservation->schedule->end_time }}</th>
                        <th>{{ $reservation->screen_no }}</th>
                        <th>{{ $reservation->sheet_id }}</th>
                        <th>{{ strtoupper($reservation->sheet->row.$reservation->sheet->column) }}</th>
                        <th>{{ $reservation->date }}</th>
                        <th>{{ $reservation->name }}</th>
                        <th>{{ $reservation->email }}</th>
{{--                        
                        <td>
                            <form action="{{ route('adminreservecreate')}}" method="get">
                                <input type = "hidden" type="text" name="scheduleId" value="{{ $reservation->schedule_id  }}" >
                                <input type = "hidden" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
                                <button type="submit">座席を予約する</button>
                            </form>
                        </td>
--}}
                        <td>
                            <form action="{{ route('admineditSheet', ['id'=>$reservation->id]) }}" method="get">
                                <input type = "hidden" type="text" name="movieid" value="{{ $reservation->schedule->movie_id }}" >
                                <input type = "hidden" type="text" name="scheduleId" value="{{ $reservation->schedule_id  }}" >
                                <input type = "hidden" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
                                <button type="submit">編集</button>
                            </form>
                        </td>       
                        <td>
                            <form action="{{ route('admindestroySheet', ['id'=>$reservation->id]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">削除</button>
                            </form>                
                        </td>
                    </tr>
                @endif

            @endforeach
        </table>

        <br><br>
    </div>
</body>
</html>