@extends('layouts.app')

@section('content')
<div class="container small">
  <h1>Movie編集</h1>
  <form action="{{ route('update', ['id'=>$movie->id]) }}" method="POST">
  @method('PATCH')
  @csrf
    <fieldset>
        <div class="form-group">
            <!--タイトル -->
            <label for="title">{{ __('映画タイトル') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="title" id="title" value = {{ $movie->title}}>

            <!-- 画像URL -->
            <label for="image_url">{{ __('画像URL') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="image_url" id="image_url" value = {{ $movie->image_url}}>

            <!-- 公開年 -->
            <label for="published_year">{{ __('公開年') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="published_year" id="published_year"  value = {{ $movie->published_year}}>

            <!-- 公開中かどうか -->
            <br>
            <label for="is_showing">{{ __('公開中かどうか') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <br>
            @if( $movie->is_showing ==1 )
                <input type="checkbox" name="is_showing" value=true checked>
            @else
                <input type="checkbox" name="is_showing" value=false>      
            @endif
            上映中
            <br>

            <!-- 概要 -->
            <br>
            <label for="description">{{ __('概要') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <br>
            <textarea name="description">{{ $movie->description }}</textarea>
            <br>

            <!--ジャンル -->
            <label for="genre">{{ __('ジャンル') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="genre" id="genre" value = {{ $movie->genre_name}}>

        </div>

        <div class="d-flex justify-content-between pt-3">
            <a href="{{ route('list') }}" class="btn btn-outline-secondary" role="button">
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