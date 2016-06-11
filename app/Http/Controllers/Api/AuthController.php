<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\UsersCRUDValidators;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    use UsersCRUDValidators;

    /**
     * Signs in a user using JWTAuth service.
     * Returns authentication token or an error in JSON format
     *
     * @param Request $request
     * @param JWTAuth $auth
     * @return mixed
     */
    public function signIn(Request $request, JWTAuth $auth)
    {
        $credentials = $request->only('email', 'password');
        $custom_claims = User::getCustomClaims($request->email);

        if (! $token = $auth->attempt($credentials, $custom_claims)) {
            return rest_error_response(
                Response::HTTP_UNAUTHORIZED,
                'Invalid credentials'
            );
        }

        return rest_data_response([
            'token' => $token,
            'user'  => User::getByEmail($request->email)->toArray(),
        ]);
    }

    /**
     * Signs in a user using JWTAuth service.
     * Returns authentication token or an error in JSON format
     *
     * @param Request $request
     * @param JWTAuth $auth
     * @return mixed
     */
    public function signUp(Request $request, JWTAuth $auth)
    {
        $data = $request->all();

        $validator = $this->userSignUpValidator($data);
        if ($validator->fails()) {
            $errors = $validator->getMessageBag()->all();

            return rest_error_response(
                Response::HTTP_BAD_REQUEST,
                'Bad request',
                $errors
            );
        }

        if (User::getByEmail($request->email)) {
            return rest_error_response(
                Response::HTTP_CONFLICT,
                'User already exists'
            );
        }

        $custom_claims = User::getCustomClaims($request->email);
        $user = User::create($data);
        $token = $auth->fromUser($user, $custom_claims);

        return rest_data_response([
            'token' => $token,
            'user'  => $user->toArray(),
        ]);
    }
}
