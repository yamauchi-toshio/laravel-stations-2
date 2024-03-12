<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Schedule extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'schedules';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'id',
        'movie_id',
        'start_time',
        'end_time',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
//        'start_time_date' => 'datetime',
//        'start_time_time' => 'datetime',
//        'end_time_date' => 'datetime',
//        'end_time_time' => 'datetime',
    ];

    //逆向きのリレーション定義
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    //リレーション定義
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
