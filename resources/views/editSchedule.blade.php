@extends('layouts.app')

@section('content')
<div class="container small">
  <h1>スケジュール編集</h1>
  <form action="{{ route('updateSchedule', ['id'=>$schedule->id]) }}" method="POST">
  @method('PATCH')
  @csrf
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif    

    <fieldset>
        <h2>[ID]：{{ $movie->id }}　[映画タイトル]：{{ $movie->title }}</h2>
        <div class="form-group">
            <input type="hidden" type="text" class="form-control" name="movie_id" id="movie_id" value = {{ $movie->id}}>            

            <label for="start_time_date">{{ __('上映開始日付') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="date" class="form-control" name="start_time_date" id="start_time_date" value = {{ $schedule->start_time_date}}>            
            <br>
            <label for="start_time_time">{{ __('上映開始時間') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="time" class="form-control" name="start_time_time" id="start_time_time" value = {{ $schedule->start_time_time}}>            
            <br>
            <label for="end_time_date">{{ __('上映終了日付') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="date" class="form-control" name="end_time_date" id="end_time_date" value = {{ $schedule->end_time_date}}>            
            <br>
            <label for="end_time_time">{{ __('上映終了時間') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="time" class="form-control" name="end_time_time" id="start_time_time" value = {{ $schedule->end_time_time}}>            
        </div>

        <div class="d-flex justify-content-between pt-3">
            <a href="{{ route('createSchedule', ['id'=>$movie->id]) }}" class="btn btn-outline-secondary" role="button">
                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('一覧画面へ') }}
            </a>
            <button type="submit" class="btn btn-success">
                {{ __('更新') }}
            </button>
        </div>
    </fieldset>
  </form>
</div>
@endsection