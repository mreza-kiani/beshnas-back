<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Match;
use App\Models\Option;
use App\Models\Question;
use App\Utils\Message\MessageFactory;
use App\Utils\Services\ReportServices\MatchReporter;
use App\Utils\Services\ReportServices\UserProgressReporter;
use Exception;
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
                    ['messages.match.existing_match'], 200, ["data" => $match]
                ), 200);

            $match = Match::create([
                "status" => Match::$status['playing'],
                "type" => Match::$type['solo']
            ]);

            $match->users()->attach($user->id);

            $questions = Question::inRandomOrder()->notInUserQuestions($user)->get()->take(Match::getQuestionCounts());
            $match->questions()->attach($questions->lists('id')->toArray());

            return response()->json(MessageFactory::create(
                ['messages.match.match_added'], 200, ["data" => $match]
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
        return response()->json([
            "data" => $match->questions()->with('options')->get()->get($match->pivot->answered_questions)
        ]);
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

    /**
     * @rules(match_id="required|exists:matches\,id")
     * @permissionSystem(displayName="actions.solo_match_controller.report")
     * @description(return="ReportObject", comment="api will get a match id and will return a ReportObject")
     */
    public function getReport()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $match = Match::whereHas('users', function ($query) use ($user){
            $query->whereId($user->id);
        })->find(request('match_id'));

        if (is_null($match))
            return response()->json(MessageFactory::create(
                ['messages.match.no_match_found'], 403
            ), 403);

        return response()->json((new MatchReporter($user, $match))->getReport(), 200);
    }
}