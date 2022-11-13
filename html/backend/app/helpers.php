<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('generateAccessToken')) {
    function generateAccessToken()
    {
        return Str::random(64);
    }
}