<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Contracts\Events\Dispatcher;

class JWTAuthMiddleware
{

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param \Tymon\JWTAuth\JWTAuth $auth
     * @param Dispatcher $events
     */
    public function __construct(JWTAuth $auth, Dispatcher $events)
    {
        $this->auth = $auth;
        $this->events = $events;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return rest_error_response(Response::HTTP_BAD_REQUEST,
                'The token could not be parsed from the request');
        }

        $user = $this->auth->authenticate($token);

        if (! $user) {
            return rest_error_response(Response::HTTP_NOT_FOUND,
                'User not found');
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}
