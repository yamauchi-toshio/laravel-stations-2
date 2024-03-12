<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'reservations';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'id',
        'date',
        'schedule_id',
        'sheet_id',
        'email',
        'name',
        'is_canceled',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];    

    //逆向きのリレーション定義
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function sheet()
    {
        return $this->belongsTo(Sheet::class);
    }

}
