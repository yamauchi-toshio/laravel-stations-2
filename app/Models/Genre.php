<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Genre extends Model
{
    use HasFactory;

    // モデルに関連付けるテーブル
    protected $table = 'genres';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';
    
    //複数代入する属性
    protected $fillable = ['name'];

    //リレーション定義
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }




}
