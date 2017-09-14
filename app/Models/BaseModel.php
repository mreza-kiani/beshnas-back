<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/15/16
 * Time: 4:42 PM
 */

namespace App\Models;

use App\Utils\Jalali\jDate;
use App\Utils\Validation\DataValidation;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property integer id
 *
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{

    public function toArray()
    {
        $parentResponse = parent::toArray();
        foreach ($parentResponse as $key => $value) {
            if (DataValidation::validateDate($value)) {
                $parentResponse[$key . "_jalali"] = jDate::forge($value)->format("Y/m/d H:i");
            }
        }
        $parentResponse['className'] = get_class($this);
        return $parentResponse;
    }
}