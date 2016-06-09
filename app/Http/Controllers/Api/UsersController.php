<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\UsersCRUDValidators;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Route;
use Tymon\JWTAuth\JWTAuth;

class UsersController extends Controller
{

    const USERS_PER_PAGE = 10;
    use UsersCRUDValidators;

    public function __construct(JWTAuth $auth)
    {
        $this->middleware('jwt-auth');
        $user = null;

        $route = Route::getCurrentRoute();
        if ($route) {
            $user = $route->getParameter('user');
        }

        // Allow common user show and update only herself
        $except = ['show', 'update', 'changePassword'];
        if (! $auth->getToken() ||
            ! $user ||
            $user->id != $auth->toUser($auth->getToken())->id
        ) {
            $except = [];
        }

        $this->middleware('permission:manage-user', ['except' => $except]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = [];

        if ($request->email) {
            $filters[] = ['email', 'LIKE', "%{$request->email}%"];
        }
        if ($request->name) {
            $filters[] = ['name', 'LIKE', "%{$request->name}%"];
        }

        return rest_data_response(
            User::where($filters)
                ->orderBy('email', 'asc')
                ->paginate(static::USERS_PER_PAGE)
                ->toArray()
        );
    }

    /**
     * Display a user with a given ID
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $info = $user->toArray();
        $info['roles'] = $user->roles->toArray();

        return rest_data_response($info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'calories_per_day'
        ]);

        $validator = $this->userCreateValidator($data);
        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        $user = User::create($data);
        $user->roles()->sync((array)$request->roles);

        return rest_data_response($user->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->only([
            'name',
            'email',
            'calories_per_day',
        ]);

        $validator = $this->userUpdateValidator($data);
        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->calories_per_day = $data['calories_per_day'];
        $user->save();
        $user->roles()->sync((array)$request->roles);

        return rest_data_response($user->toArray());
    }

    /**
     * Change a password of the specified user
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, User $user)
    {
        $data = $request->only([
            'password',
        ]);

        $validator = $this->userChangePasswordValidator($data);
        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        $user->password = bcrypt($data['password']);
        $user->save();

        return rest_data_response([
            'message' => 'Password successfully changed',
            'id'      => $user->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->clearMealsCache();
        $user->delete();

        return rest_data_response([
            'message' => 'User successfully deleted',
            'id'      => $user->id,
        ]);
    }
}
