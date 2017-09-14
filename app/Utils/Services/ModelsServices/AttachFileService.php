<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/10/16
 * Time: 4:39 PM
 */

namespace App\Utils\Services\ModelsServices;


use App\Models\AttachFile;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AttachFileService
{

    /**
     * @param BaseModel $object
     * @param Request $request
     */
    public static function addFilesToObj(BaseModel $object, Request $request)
    {
        if (is_array($request->input('attachFileIds')))
            foreach ($request->input('attachFileIds') as $fileId) {
                $attachFile = AttachFile::find($fileId);
                $attachFile->attachable_type = get_class($object);
                $attachFile->attachable_id = $object->id;
                $attachFile->creator_id = JWTAuth::parseToken()->authenticate()->id;
                $attachFile->save();
            }
    }
}