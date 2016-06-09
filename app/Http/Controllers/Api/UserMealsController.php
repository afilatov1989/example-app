<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\MealsCRUDValidators;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Route;
use Tymon\JWTAuth\JWTAuth;

class UserMealsController extends Controller
{

    use MealsCRUDValidators;

    public function __construct(JWTAuth $auth)
    {
        $user = null;
        $route = Route::getCurrentRoute();
        if ($route) {
            $user = $route->getParameter('user');
        }

        $this->middleware('jwt-auth');

        // if user tries to deal with another user's records, check permission
        if (! $user || ! $auth->getToken() || $user->id != $auth->toUser($auth->getToken())->id) {
            $this->middleware('permission:manage-record');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @param Request $request
     * @return Response
     * @internal param User $user
     */
    public function index(User $user, Request $request)
    {
        $datetime_filter = $request->only([
            'date-from',
            'date-to',
            'time-from',
            'time-to'
        ]);

        $validator = $this->indexValidator($datetime_filter);

        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        return rest_data_response($user->mealsFormattedOutput($datetime_filter));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
        $data = $request->only(['date', 'time', 'text', 'calories']);

        $validator = $this->createUpdateValidator($data);
        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        $meal = $user->meals()->create($data);

        $user->clearMealsCache();

        return rest_data_response($meal->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param User $user_id
     */
    public function update(User $user, Request $request, $id)
    {
        $data = $request->only(['date', 'time', 'text', 'calories']);

        $validator = $this->createUpdateValidator($data);
        if ($validator->fails()) {
            return rest_validator_error_response($validator);
        }

        $meal = $user->findMealByIDOrFail($id);
        $meal->date = $data['date'];
        $meal->time = $data['time'];
        $meal->text = $data['text'];
        $meal->calories = $data['calories'];
        $meal->save();

        $user->clearMealsCache();

        return rest_data_response($meal->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param User $user_id
     */
    public function destroy(User $user, $id)
    {
        $meal = $user->findMealByIDOrFail($id);
        $meal->delete();

        $user->clearMealsCache();

        return rest_data_response([
            'message' => 'Meal successfully deleted',
            'id'      => $id,
        ]);
    }
}
