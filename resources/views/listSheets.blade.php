<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>座席一覧</title>
</head>
<body>
    <script>

    </script>
    <h1>座席一覧</h1>

    <div>

    <table border="3" bordercolor=green>
        @foreach ($sheets as $sheet)
            @if( $sheet->row == 'a' && $sheet->column == '1')
                <tr>
                    <th colspan="5">スクリーン{{ $sheet->screen_no }}</th>
                </tr>
            @endif

            @if( $sheet->column == 1 )
                <tr>
            @endif
            <th>{{ $sheet->row }}-{{ $sheet->column }}</th>
            @if( $sheet->column == 5 )
                </tr>
            @endif
        @endforeach
    </table>
    </div>
</body>
</html>