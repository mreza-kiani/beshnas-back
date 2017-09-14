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
 * @property integer match_id
 * @property integer user_id
 * @property integer question_id
 * @property integer option_id
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * @property Match match
 * @property User user
 * @property Question question
 * @property Option option
 *
 * @method static Answer find (integer $id)
 *
 * Class Answer
 * @package App\Models
 */
class Answer extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function match()
    {
        return $this->belongsTo(Match::class, 'match_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}