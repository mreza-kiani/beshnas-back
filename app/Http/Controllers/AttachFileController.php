<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/10/16
 * Time: 12:32 PM
 */

namespace App\Http\Controllers;


use App\Models\AttachFile;
use App\Utils\Validation\DataValidation;

class AttachFileController extends Controller
{
    public function anyUpload()
    {
        $input_name = 'file';
        //save attachFile from input to uploads folder
        $filename = request()->file($input_name)->getClientOriginalName();
        $filename = DataValidation::urlEncode($filename);
        $destinationPath = 'uploads/attach-files/' . (string)microtime(true) . str_random(10);

        request()->file($input_name)->move($destinationPath, $filename);

        $attachFile = new AttachFile();
        $attachFile->path = $destinationPath;
        $attachFile->real_name = $filename;
        $attachFile->attachable_type = 'NONE';
        $attachFile->attachable_id = 1;
        $attachFile->save();

        return $attachFile->id;
    }
}