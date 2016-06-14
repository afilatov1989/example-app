<?php

namespace App\Http\Controllers\Api\Traits;

use App\User;
use Validator;

trait UsersCRUDValidators
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function userSignUpValidator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255|min:4',
            'email'    => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Get a validator for an incoming user creation request.
     * Contrary to registration, can be sent only by admins
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function userCreateValidator(array $data)
    {
        return Validator::make($data, [
            'name'             => 'required|max:255|min:4',
            'email'            => 'required|email|max:255|unique:users,email',
            'password'         => 'required|min:6',
            'calories_per_day' => 'required|integer|min:0',
            'roles'            => 'array',
            'roles.*'          => 'integer|exists:roles,id',
        ]);
    }

    /**
     * Get a validator for an incoming user update request.
     *
     * @param  array $data
     * @param User $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function userUpdateValidator(array $data, User $user)
    {
        return Validator::make($data, [
            'name'             => 'required|max:255|min:4',
            'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
            'calories_per_day' => 'required|integer|min:0',
            'roles'            => 'array',
            'roles.*'          => 'integer|exists:roles,id',
        ]);
    }

    /**
     * Get a validator for an incoming user update request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function userChangePasswordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|min:6',
        ]);
    }
}