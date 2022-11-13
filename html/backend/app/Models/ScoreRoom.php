<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Utils\DBU;

class ScoreRoom extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'app_db.' . 'score_rooms';
    protected $guarded = ['created_at', 'updated_at'];

    public function user()
    {
        // return $this->hasOne(User::class)->where('status', '=', 1);
    }

}
