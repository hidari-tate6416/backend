<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Utils\MasterUtil;

use App\Models\Color;

class MenuService
{
    public function createScoreRoom()
    {
        return MasterUtil::getColorAll();
    }
}