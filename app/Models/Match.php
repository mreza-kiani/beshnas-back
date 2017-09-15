<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 8/13/16
 * Time: 5:06 PM
 */

namespace App\Models;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer id
 * @property integer status
 * @property integer type
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

    protected $fillable = [
        'status', 'type'
    ];

    public static $status = [
        "waiting" => 0,
        "playing" => 1,
        "finished" => 2,
    ];

    public static $type = [
        "solo" => 1,
        "multi" => 2,
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
        return $this->belongsToMany(Question::class, 'match_question', 'match_id','question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'match_id');
    }

    /**
     * @param Builder $builder
     * @param String $status
     * @return Builder
     */
    public function scopeStatus($builder, $status)
    {
        return $builder->whereStatus(Match::$status[$status]);
    }

    /**
     * @param Builder $builder
     * @param String $type
     * @return Builder
     */
    public function scopeType($builder, $type)
    {
        return $builder->whereType(Match::$type[$type]);
    }
}