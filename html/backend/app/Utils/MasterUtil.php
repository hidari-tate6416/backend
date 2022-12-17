<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Models\Color;
use App\Models\Member;

class MasterUtil
{
    static function getColorAll()
    {
        $result = array();

        $colors = Color::where('status', '=', 1)
            ->get();
        foreach ($colors as $color) {
            $result[] = array(
                'id' => $color->id,
                'name' => $color->name_ja,
                'rgb' => $color->code
            );
        }

        return $result;
    }
}