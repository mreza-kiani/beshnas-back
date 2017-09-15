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
 * @property string text
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * @property Match[] matches
 * @property Option[] options
 * @property Answer[] answers[]
 *
 * @method static Question find (integer $id)
 *
 * Class Question
 * @package App\Models
 */
class Question extends BaseModel
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(Option::class, 'question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matches()
    {
        return $this->belongsToMany(Match::class, 'match_question', 'question_id', 'match_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    /**
     * @param Builder $builder
     * @param User $user
     * @return Builder
     */
    public function scopeNotInUserQuestions($builder, $user)
    {
        return $builder->whereDoesntHave('answers', function ($query) use ($user){
            $query->where('user_id', '=', $user->id);
        });
    }
}