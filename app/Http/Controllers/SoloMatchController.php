<?php

namespace App\Http\Controllers;

use App\Models\Match;
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
     * @description(return="added Question|messages", comment="api will create a new Match and will return first question")
     */
    public function postStart()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $match = Match::create([
                "status" => Match::$status['playing'],
                "type" => Match::$type['solo']
            ]);

            $match->users()->attach($user->id);

            $questions = Question::inRandomOrder()->take(Match::getQuestionCounts());
            $match->questions()->attach($questions->lists('id'));

            $question = $questions->first();
            $question->load('options');

            return response()->json(MessageFactory::create(
                ['messages.match.match_added'], 200, compact('question')
            ), 200);
        } catch (Exception $e) {
            return response()->json(MessageFactory::create(
                ['messages.match.unaccepted_error', $e->getMessage()->first()], 409
            ), 409);
        }
    }
}