<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'app_db.' . 'user_types';

    protected $guarded = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class)->where('status', '=', 1);
    }
}
