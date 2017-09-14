<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/28/16
 * Time: 2:27 AM
 */

namespace App\Http\Controllers;

class AppController extends Controller
{
    public function main()
    {
        $pathParts = explode('/', str_replace('-','_',request()->path()));
        $bladeName = join('.', $pathParts);
        try {
            return view($bladeName);
        } catch (\InvalidArgumentException $invalidArgumentException) {
            try {
                return view($bladeName . '.layout');
            } catch (\InvalidArgumentException $invalidArgumentException) {
                return response(view('errors.404'), 404);
            }
        }
    }
}