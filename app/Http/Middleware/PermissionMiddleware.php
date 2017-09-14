<?php

/**
 * Created by PhpStorm.
 * User: arash
 * Date: 7/26/16
 * Time: 8:30 PM
 */
namespace App\Http\Middleware;

use App\Models\User;
use App\Utils\Message\MessageFactory;
use App\Utils\Reflection\Action;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class PermissionMiddleware
 * @package App\Http\Middleware
 */
class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $action = Action::withRequest($request);
        if ($action->getClass()->needsLogin() or $action->getMethod()->needsLogin()) {
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
                    ['messages.auth.token_absent', $e->getMessage()], $e->getStatusCode()
                ), $e->getStatusCode());
            }
        }
        return $next($request);
    }
}