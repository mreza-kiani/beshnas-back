<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 2/15/17
 * Time: 7:19 PM
 */

namespace App\Models;


interface Pageable
{
    public static function paginationCount();

    public function scopeGeneralRelations($query);

    public function scopeIndividualRelations($query);
}