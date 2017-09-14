<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/8/16
 * Time: 12:34 AM
 */

namespace App\Utils\Common;


class AttachFileService
{
    public static function saveImage($category)
    {
        $imageName = request()->file('image')->getClientOriginalName();
        $imageName = str_replace(' ', '', $imageName);
        $destinationPath = '/uploads/' . $category . '/' . (string)microtime(true) . str_random(10);

        request()->file('image')->move(public_path() . $destinationPath, $imageName);

        $imageObj = new \stdClass();
        $imageObj->name = $imageName;
        $imageObj->destinationPath = $destinationPath;
        return $imageObj;
    }
}