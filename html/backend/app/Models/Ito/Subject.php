<?php

namespace App\Models\Ito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'ito_db.' . 'subjects';

    protected $guarded = ['created_at', 'updated_at'];

    public function templete()
    {
        return $this->belongsTo(Templete::class);
    }
}
