<?php
/**
 * Created by PhpStorm.
 * User: mamareza
 * Date: 8/9/17
 * Time: 9:15 PM
 */

namespace App\Utils\Common;

class RequestService
{
    public static function setAttr($key, $value, $request=null){
        $request = $request==null ? request() : $request;
        $request->merge([$key => $value]);
    }

    public static function getAttr($key, $request=null){
        $request = $request==null ? request() : $request;
        return $request->get($key);
    }

    public static function hasAttr($key, $request=null){
        $request = $request==null ? request() : $request;
        return $request->has($key);
    }

    public static function isRequestAjax($request=null){
        $request = $request==null ? request() : $request;
        return $request->json();
    }
}