<?php

namespace App\Models\Ito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templete extends Model
{
    use HasFactory;

    protected $table = 'ito_db.' . 'templetes';

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
