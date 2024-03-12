<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'movies';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';
    
    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'id',
        'title',
        'image_url',
        'published_year',
        'is_showing',
        'description',
        'genre',
        'created_at',
        'updated_at'
    ];

    public function InsertMovies($request)
    {
        // リクエストデータを基に登録する
        if ($request->is_showing == true){
            $FLG1 = 1;
        }else{
            $FLG1 = 0;
        }

        return $this->create([
            'title'             => $request->title,
            'image_url'         => $request->image_url,
            'published_year'    => $request->published_year,
            'is_showing'        => $FLG1,
            'description'       => $request->description,
            'genre'             => $request->genre,
        ]);

    }

    //逆向きのリレーション定義
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    //リレーション定義
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    
}
