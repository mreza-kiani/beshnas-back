<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 8/12/17
 * Time: 3:41 PM
 */

namespace App\Utils\Common;


use Exception;
use Illuminate\Support\Facades\Schema;

class ModelService
{
    private static $namespace = "\\App\\Models\\";

    public static function isValidModelByField($modelName, $field){
        try{
            if (!Schema::hasColumn(self::getTableName($modelName), $field)){
                return false;
            }
        } catch (Exception $e){
            return false;
        }
        return true;
    }

    public static function isValidModel($modelName){
        if(class_exists($modelName))
            return true;
        return class_exists(self::$namespace.$modelName);
    }

    public static function getTableName($modelName){
        $model = "";
        eval("\$model = new ".self::model($modelName)."();");
        return $model->getTable();
    }

    public static function className($modelName){
        $nameParts = (explode("\\", $modelName));
        return end($nameParts);
    }

    /**
     * @param $modelName
     * @return bool|string
     */
    public static function model($modelName){
        if(class_exists(self::$namespace.$modelName))
            return self::$namespace.$modelName;
        if(class_exists($modelName))
            return $modelName;
        return false;
    }
}