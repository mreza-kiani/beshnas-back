<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/11/16
 * Time: 6:24 PM
 */

namespace App\Http\Controllers;

use App\Models\NotificationDevice;
use App\Models\Tag;
use App\Models\User;
use App\Utils\Message\MessageFactory;
use App\Utils\Services\ReportServices\UserProgressReporter;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Utils\Services\RoutineServices\DateService;


/**
 * Class AuthController
 * @package App\Http\Controllers\Api\V1
 * @permissionSystem(displayName="actions.auth.root")
 */
class AuthController extends Controller
{
    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.login")
     */
    public function getReport()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json((new UserProgressReporter())->getReport($user), 200);
    }

    /**
     * @permissionSystem(loginNeeded=false, displayName="actions.auth.get_csrf_token")
     */
    public function getCsrfToken()
    {
        return response()->json([
            'token' => [
                'name' => '_token',
                'value' => csrf_token()
            ]
        ]);
    }

    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.get_authenticated_user")
     */
    public function getAuthenticatedUser()
    {
        try {
            /** @var User $user */
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(MessageFactory::create(
                    ['messages.auth.user_not_found'], 403
                ), 403);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(MessageFactory::create(
                ['messages.auth.token_expired'], $e->getStatusCode()
            ), $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(
                MessageFactory::create(
                    ['messages.auth.token_invalid'], $e->getStatusCode()
                ), $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(MessageFactory::create(
                ['messages.auth.token_absent'], $e->getStatusCode()
            ), $e->getStatusCode());
        }

        $user->actionAddresses = $user->actionAddresses();
        return response()->json(
            MessageFactory::create(
                ['messages.auth.token_is_valid' => ['name' => $user->name]], 200, compact('user')
            ), 200
        );
    }

    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.check_password")
     * @rules(old_password="required", new_password="required|confirmed", new_password_confirmation="required")
     */
    public function postChangePassword()
    {
        $authUser = $user = JWTAuth::parseToken()->authenticate();
        if (!Auth::validate(array('email' => $authUser->email, 'password' => request()->input('old_password')))) {
            return response()->json(MessageFactory::create(
                ['messages.auth.wrong_old_password'], 400
            ), 400);
        } else {
            $user->password = bcrypt(request()->input("new_password"));
            $user->save();
            return response()->json(MessageFactory::create(
                ['messages.auth.change_password_done'], 200
            ), 200);
        }
    }

    /**
     * @permissionSystem(loginNeeded=false, displayName="actions.auth.forget_password")
     * @rules(email="required|email|exists:users")
     */
    public function postForgetPassword()
    {
        $user = User::whereEmail(request()->input('email'))->first();
        if (isset($user->id)) {
            //removing all previous sessions
            request()->session()->forget(session('token_name'));

            $token = hash_hmac('sha256', Str::random(40), $user->email);
            session([$token => $user, 'token_name' => $token]);
            try {
                Mail::send('emails.change_password', ['user' => $user, 'token' => $token], function ($mail) use ($user) {
                    $mail->from(config('automation.sender_mail'), config('automation.app_name'));
                    $mail->to($user->email, $user->name)->subject(trans('general.forget_password'));
                });
                return response()->json(MessageFactory::create(
                    ['messages.auth.change_password_mail_sent'], 200
                ), 200);
            } catch (Exception $e) {
                return response()->json(MessageFactory::create(
                    ['messages.auth.mail_send_error', $e->getMessage()], 500
                ), 500);
            }
        } else {
            return response()->json(MessageFactory::create(
                ['messages.auth.email_not_found' => ['email' => request()->input('email')]], 404
            ), 404);
        }
    }

    /**
     * @permissionSystem(loginNeeded=false, displayName="actions.auth.reset_password")
     * @rules(token="required",new_password="required|confirmed", new_password_confirmation="required")
     */
    public function postResetPassword()
    {
        $token = request()->input('token');
        if (request()->session()->has($token)) {
            $user = session($token);
            $user->password = bcrypt(request()->input("new_password"));
            $user->save();
            request()->session()->forget($token);

            //logging in the reset password user
            $token = JWTAuth::fromUser($user);
            return response()->json(
                MessageFactory::create([
                    'messages.auth.reset_password_successful',
                    'messages.auth.login_successful'
                ], 200, compact('token')
                ), 200);
        } else {
            return response()->json(MessageFactory::create(
                ['messages.auth.chpass_token_expired'], 498
            ), 498);
        }
    }

    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.has_permission")
     * @rules(action="required")
     */
    public function postHasPermission()
    {
        $authUser = JWTAuth::parseToken()->authenticate();
        $response = $authUser->hasPermission(request()->input('action'));
        return ($response) ?
            response()->json(["response" => $response], 200) :
            response()->json(
                MessageFactory::create(
                    ['messages.auth.action_not_permitted'], 403, ["response" => $response]
                ), 403
            );
    }

    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.edit_profile")
     * @rules(name="required", bio="max:450")
     */
    public function postEditProfile(){
        $authUser = JWTAuth::parseToken()->authenticate();
        $authUser->name = request()->input("name");
        $authUser->bio = request()->input("bio");
        $authUser->save();

        return response()->json(MessageFactory::create(
            ['messages.auth.profile_edited'], 200
        ), 200);
    }

    /**
     * @rules(file="image")
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.change_image")
     * @description(return="UserObject", comment="send an image as a file and system will save it")
     */
    public function postChangeImage()
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        //save photo from input to uploads folder
        $imageName = request()->file('file')->getClientOriginalName();
        $imageName = str_replace(' ', '', $imageName);
        $destinationPath = '/uploads/users/' . (string)microtime(true) . str_random(10);
        request()->file('file')->move(public_path() . $destinationPath, $imageName);

        $authUser->image_path = $destinationPath . "/" . $imageName;
        $authUser->save();

        return response()->json(MessageFactory::create(
            ['messages.auth.image_changed'], 200, compact('authUser')
        ), 200);
    }

    /**
     * @rules(token="required")
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.set_android_token")
     * @description(return="just some messages", comment="you must send the token received from the google server to this api")
     */
    public function postSetAndroidToken(){
        $authUser = JWTAuth::parseToken()->authenticate();
        $authUser->android_token = request()->input("token");
        $authUser->save();

        return response()->json(MessageFactory::create(
            ['messages.auth.token_added_to_the_system'], 200, compact('authUser')
        ), 200);
    }

    /**
     * @permissionSystem(loginNeeded=true, displayName="actions.auth.remove_image")
     * @description(return="UserObject", comment="send user id to delete his photo")
     */
    public function deleteRemoveImage()
    {
        $authUser = JWTAuth::parseToken()->authenticate();

        $authUser->image_path = '/static/assets/img/profile-no-photo.jpg';
        $authUser->save();

        return response()->json(MessageFactory::create(
            ['messages.auth.image_removed'], 200
        ), 200);
    }


    /**
     * @permissionSystem(loginNeeded=false, displayName="actions.auth.get_today_date")
     * @description(return="date in a particular format", comment="this api is used for getting date of today for auth user")
     */
    public function getTodayDate(){
        return response()->json(DateService::todayDate());
    }
}