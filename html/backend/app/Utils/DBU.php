<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Models\Color;
use App\Models\Member;

class DBU
{
    use SoftDeletes;

    private static $databases = array();

    public static function beginTransaction()
    {
        self::getConnections();
        foreach (self::$databases as $db){
            DB::connection($db)->beginTransaction();
        }
    }

    public static function commit()
    {
        self::getConnections();
        foreach (self::$databases as $db){
            DB::connection($db)->commit();
        }
    }

    public static function rollBack()
    {
        self::getConnections();
        foreach (self::$databases as $db){
            DB::connection($db)->rollBack();
        }
    }

    private static function getConnections()
    {
        if (!empty(self::$databases)){
            return;
        }

        $dbs = config('database.connections');
        foreach ($dbs as $db => $dst){
            if (strpos($db, 'mysql_') === 0){
                self::$databases[] = $db;
            }
        }
    }

    static function getColor($color_id)
    {
        $color = Color::where('status', '=', 1)
            ->find($color_id);

        return $color;
    }

    static function getName($member_id)
    {
        $member = Member::where('status', '=', 1)
            ->find($member_id);

        return $member->name;
    }
}