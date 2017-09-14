<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 10/26/16
 * Time: 3:43 PM
 */

namespace App\Utils\Services\ControllersServices;


class ResultGenerator
{
    public static function make($query, $paginateCount){
        if (request()->has('page')){
            return response()->json($query->generalRelations()->paginate($paginateCount));
        }
        else if (request()->has('count')){
            return response()->json($query->get()->count());
        }
        else {
            return response()->json($query->generalRelations()->individualRelations()->get());
        }
    }
}