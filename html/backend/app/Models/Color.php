<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Utils\DBU;

class Color extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'app_db.' . 'colors';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        // return $this->hasOne(User::class)->where('status', '=', 1);
    }

}
