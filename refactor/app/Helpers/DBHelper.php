<?php 

namespace App\Helper;
use Carbon\Carbon;


class DBHelpers{
    public static function addDBWhereIn($query, $col, $arr){
        return $query->whereIn($col, $arr)->where('jobs.status', 'pending')->where('jobs.ignore_expired', 0)->where('jobs.due', '>=', Carbon::now());
    }
    public static function addDBWhere($query, $col, $val, $compare = '='){
        return $query->where($col, $val)->where('jobs.status', $compare, 'pending')->where('jobs.ignore_expired', 0)->where('jobs.due', '>=', Carbon::now());
    }
}