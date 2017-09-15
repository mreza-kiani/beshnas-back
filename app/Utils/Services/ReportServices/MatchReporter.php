<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 9/15/17
 * Time: 5:36 PM
 */

namespace App\Utils\Services\ReportServices;

use App\Models\Option;

class MatchReporter extends Reporter
{
    public function setOptions()
    {
        $this->options = Option::whereHas('answers', function ($query){
            $query->whereUserId($this->user->id)->whereMatchId($this->match->id);
        })->get();
    }
}