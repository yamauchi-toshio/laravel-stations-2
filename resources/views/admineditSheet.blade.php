@extends('layouts.app')

@section('content')
<title> 管理者：予約編集(admineditSheet)</title>
<div class="container small">
  <h1>管理者：予約編集</h1>

  <form action="{{ route('sheetupdate', ['id'=>$Reservation->id]) }}" method="POST">
    @method('PATCH')
    @csrf
    <input type = "" type="text" name="movie_id" value="{{ $Reservation->schedule->movie_id }}" >
    <input type = "" type="text" name="schedule_Id" value="{{ $Reservation->schedule_id  }}" >
    <input type = "" type="text" name="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
    <fieldset>
        <div class="form-group">
            <!--座席 -->
            <label for="sheet_id">{{ __('座席') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="sheet_id" id="sheet_id" value = {{ $Reservation->sheet_id}}>
        </div>

        <div class="form-group">
            <!--名前 -->
            <label for="name">{{ __('名前') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="name" id="name" value = {{ $Reservation->name}}>
        </div>
        
        <div class="form-group">
            <!--メール -->
            <label for="email">{{ __('メール') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="email" id="email" value = {{ $Reservation->email}}>
        </div>

        <div class="d-flex justify-content-between pt-3">
            <button type="submit" class="btn btn-success">
                {{ __('更新') }}
            </button>
        </div>
    </fieldset>
  </form>
</div>
@endsection