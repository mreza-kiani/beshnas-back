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
 * @property string text
 * @property integer question_id
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * @property Question question
 * @property Answer[] answers[]
 *
 * @method static Option find (integer $id)
 *
 * Class Option
 * @package App\Models
 */
class Option extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'option_id');
    }
}