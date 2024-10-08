<?php

namespace App\Models\Insider;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use \App\Models\BaseModel;

class Subject extends BaseModel
{
    use HasFactory;

    protected $table = 'insider_db.' . 'subjects';

    protected $guarded = ['created_at', 'updated_at'];

    public function templete()
    {
        return $this->belongsTo(Templete::class);
    }
}
