<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = null;
    protected $conection = null;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    static function getNew()
    {
        return new static;
    }

}
