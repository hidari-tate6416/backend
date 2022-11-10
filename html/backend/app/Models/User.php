<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'app_db.' . 'users';

    protected $guarded = ['created_at', 'updated_at'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class);
    }

}
