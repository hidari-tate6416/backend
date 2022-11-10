<?php

namespace App\Models\Insider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templete extends Model
{
    use HasFactory;

    protected $table = 'insider_db.' . 'templetes';

    protected $guarded = ['created_at', 'updated_at'];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function member()
    {
        return $this->belongsTo(\App\Models\Member::class);
    }
}
