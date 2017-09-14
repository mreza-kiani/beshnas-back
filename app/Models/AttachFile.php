<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/13/16
 * Time: 5:06 PM
 */

namespace App\Models;
use DateTime;

/**
 * @property integer id
 * @property string path
 * @property string real_name
 * @property string description
 * @property string attachable_type
 * @property integer attachable_id
 * @property integer creator_id
 * @property User creator
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * @method static AttachFile find (integer $id)
 *
 * Class AttachFile
 * @package App\Models
 */
class AttachFile extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable(){
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(){
        return $this->belongsTo('\\App\\Models\\User', 'creator_id', 'id');
    }
}