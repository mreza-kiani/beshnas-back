<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Match;
use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use App\Utils\Message\MessageFactory;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/9/16
 * Time: 3:29 PM
 */

/**
 * Class SoloMatchController
 * @package App\Http\Controllers
 * @permissionSystem(displayName="actions.solo_match_controller.root", loginNeeded=true)
 */
class SoloMatchController extends Controller
{
    /**
     * @permissionSystem(displayName="actions.solo_match_controller.register")
     * @description(return="messages", comment="api will create a new Match and will return first question")
     */
    public function postStart()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $match = $user->getActiveSoloMatch();
            if (!is_null($match))
                return response()->json(MessageFactory::create(
                    ['messages.match.existing_match'], 200, compact('match')
                ), 200);

            $match = Match::create([
                "status" => Match::$status['playing'],
                "type" => Match::$type['solo']
            ]);

            $match->users()->attach($user->id);

            $questions = Question::inRandomOrder()->get()->take(Match::getQuestionCounts());
            $match->questions()->attach($questions->lists('id')->toArray());

            return response()->json(MessageFactory::create(
                ['messages.match.match_added'], 200, compact('match')
            ), 200);
        } catch (Exception $e) {
            return response()->json(MessageFactory::create(
                ['messages.match.unaccepted_error', $e->getMessage()], 409
            ), 409);
        }
    }

    /**
     * @permissionSystem(displayName="actions.solo_match_controller.question")
     * @description(return="Question", comment="api will return next question or null on end")
     */
    public function getQuestion()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $match = $user->getActiveSoloMatch();
        if (is_null($match)){
            return response()->json(MessageFactory::create(
                ['messages.match.match_has_finished'], 200
            ), 200);
        }
        return $match->questions()->with('options')->get()->get($match->pivot->answered_questions);
    }

    /**
     * @rules(option_id="required|exists:options\,id")
     * @permissionSystem(displayName="actions.solo_match_controller.answer")
     * @description(return="Message", comment="api will book auth user option")
     */
    public function postAnswer()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $match = $user->getActiveSoloMatch();
        if (is_null($match)){
            return response()->json(MessageFactory::create(
                ['messages.match.no_match_found'], 403
            ), 403);
        }
        $option = Option::find(request('option_id'));
        Answer::create([
            "match_id" => $match->id,
            "user_id" => $user->id,
            "question_id" => $option->question_id,
            "option_id" => $option->id
        ]);

        $match->pivot->answered_questions ++;
        $match->pivot->save();

        if ($match->questions()->count() == $match->pivot->answered_questions)
            $match->update(["status" => Match::$status["finished"]]);

        return response()->json(MessageFactory::create(
            ['messages.match.answer_has_booked'], 200
        ), 200);
    }
}