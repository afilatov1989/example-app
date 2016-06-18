<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\UsersCRUDValidators;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mail;
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
        $user = User::getByEmail($request->email);

        if (! $user) {
            return rest_error_response(
                Response::HTTP_UNAUTHORIZED,
                'Invalid credentials'
            );
        }

        $custom_claims = $user->getCustomClaims();

        if (! $token = $auth->attempt($credentials, $custom_claims)) {
            return rest_error_response(
                Response::HTTP_UNAUTHORIZED,
                'Invalid credentials'
            );
        }

        $user_data = $user->toArray();

        return rest_data_response([
            'token' => $token,
            'user'  => $user_data,
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
                'User with this email already exists'
            );
        }

        $user = User::create($data);
        $custom_claims = $user->getCustomClaims();
        $user_data = $user->toArray();
        $token = $auth->fromUser($user, $custom_claims);

        return rest_data_response([
            'token' => $token,
            'user'  => $user_data,
        ]);
    }

    public function resetPass(Request $request)
    {
        if (! $request->has('email')) {
            return rest_error_response(
                Response::HTTP_BAD_REQUEST,
                'Email is not provided'
            );
        }

        $user = User::getByEmail($request->email);

        if (! $user) {
            return rest_error_response(
                Response::HTTP_NOT_FOUND,
                'User with this email is not found'
            );
        }

        $faker = \Faker\Factory::create();
        $new_password = $faker->password(10, 10);
        $user->password = bcrypt($new_password);
        $user->save();

        Mail::queue('emails.password_reset', [
            'email'    => $user->email,
            'password' => $new_password,
        ], function ($m) use ($user) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user->email, $user->name)
                ->subject('Reset password');
        });

        return rest_data_response([
            'message' => 'New credentials were sent to your email',
        ]);
    }
}
