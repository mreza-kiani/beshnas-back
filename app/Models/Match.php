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
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * @property User[] users
 * @property Question[] questions
 * @property Answer[] answers[]
 *
 * @method static Match find (integer $id)
 *
 * Class Match
 * @package App\Models
 */
class Match extends BaseModel
{
    public static $questionCounts = 10;

    public static $status = [
        "waiting",
        "playing",
        "finished",
    ];

    public static $type = [
        "solo",
        "multi",
    ];

    /**
     * @return int
     */
    public static function getQuestionCounts(): int
    {
        return self::$questionCounts;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'match_user', 'match_id','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_user', 'match_id','question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'match_id');
    }
}