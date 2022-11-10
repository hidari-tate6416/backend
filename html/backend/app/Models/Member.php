<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'app_db.' . 'members';
    protected $guarded = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class)->where('status', '=', 1);
    }

    public function templetes()
    {
        return $this->hasMany(\App\Models\Insider::class)->where('status', '=', 1);
    }

    public function login()
    {
        //
    }

    public function logout()
    {
        //
    }

    public function auth()
    {
        //
    }
}
