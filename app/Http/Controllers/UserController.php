<?php

namespace App\Http\Controllers;

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
 * Class UserController
 * @package App\Http\Controllers
 * @permissionSystem(displayName="actions.user_controller.root")
 */
class UserController extends Controller
{
    /**
     * @permissionSystem(displayName="actions.user_controller.get_list_of_users")
     */
    public function getListOfUsers()
    {
        return response()->json(User::with('roles')->get());
    }

//   regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/
    /**
     * @rules(username="required|unique:users", password="required|min:6")
     * @permissionSystem(displayName="actions.user_controller.register")
     * @description(return="added User|messages", optionalInputs="roles[list of role ids]", comment="api needs user properties and list of roles for creating user | note that list of roles are optional | you must send the role id's like [1|2|3]['|' character mentions comma]")
     */
    public function postRegister()
    {
        try {
            $user = User::create([
                'username' => request()->input('username'),
                'password' => bcrypt(request()->input('password')),
            ]);
            return response()->json(MessageFactory::create(
                ['messages.user.user_added'], 200, compact('user')
            ), 200);
        } catch (Exception $e) {
            return response()->json(MessageFactory::create(
                ['messages.user.email_exists'], 409
            ), 409);
        }
    }

    /**
     * @rules(username="required", password="required")
     * @permissionSystem(displayName="actions.user_controller.login")
     */
    public function postLogin()
    {
        // grab credentials from the request
        $credentials = request()->only('username', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(MessageFactory::create(
                    ['messages.auth.invalid_credentials'], 401
                ), 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(MessageFactory::create(
                ['messages.auth.token_creation_error'], 500
            ), 500);
        }

        // all good so return the token
        return response()->json(
            MessageFactory::create([
                'messages.auth.login_successful'
            ], 200, compact('token')
            ), 200);
    }

    /**
     * @rules(id="required|exists:users")
     * @permissionSystem(displayName="actions.user_controller.get_user", loginNeeded=true)
     * @description(return="found User|messages", comment="api returns the user with given id -> :id")
     */
    public function getGetUser()
    {
        $user = User::with('roles')->find(request()->input('id'));
        $user->actionAddresses = $user->actionAddresses();
        return response()->json($user);
    }

    /**
     * @rules(query="required")
     * @permissionSystem(displayName="actions.user_controller.query_user", loginNeeded=true)
     * @description(return="RoleObject", comment="send the query string like 'man' and system will send you a result with array of users with starting name 'man' like 'manage'")
     */
    public function getQueryUser()
    {
        $queryList = User::where('name', 'LIKE', '%' . request()->input('query') . '%')
            ->with('roles')
            ->with('assignedTasks')
            ->with('createdTasks')
            ->get();
        return response()->json($queryList);
    }
}