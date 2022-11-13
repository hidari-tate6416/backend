<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
}