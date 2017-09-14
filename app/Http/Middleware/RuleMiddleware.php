<?php

namespace App\Http\Middleware;

use App\Utils\Common\RequestService;
use App\Utils\Message\MessageFactory;
use App\Utils\Reflection\Action;
use Closure;
use Illuminate\Support\Facades\Validator;

class RuleMiddleware
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
        $method = Action::withRequest($request)->getMethod();
        if ($method->hasAnnotation("rules")) {
            $rules = $method->getAnnotation("rules")->getProperties();
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                if (RequestService::isRequestAjax($request)) {
                    return response()->json(
                        MessageFactory::createWithValidationMessages(
                            $validator->messages()->toArray(),
                            400, [
                            "request_data" => $request->all()
                        ]), 400);
                } else {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
        }
        return $next($request);
    }
}
