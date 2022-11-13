<?php

namespace App\Models\Insider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use \App\Models\BaseModel;

class Templete extends BaseModel
{
    use HasFactory;

    protected $table = 'insider_db.' . 'templetes';

    protected $guarded = ['created_at', 'updated_at'];

    public function subjects()
    {
        return $this->hasMany(Subject::class)->where('status', '=', 1);
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}
