<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Sheet extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'sheets';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    //リレーション定義
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
