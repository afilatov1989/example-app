<?php

namespace App;

use Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{

    use EntrustUserTrait;

    const CALORIES_PER_DAY_DEFAULT = 2000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'calories_per_day',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public static function create(array $data = [])
    {
        if (! array_key_exists('calories_per_day', $data)) {
            $data['calories_per_day'] = static::CALORIES_PER_DAY_DEFAULT;
        }
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }

    /**
     * Returns custom claims for token generating by user email.
     * If user is not found, returns an empty array
     *
     * @param string $email
     * @return array
     */
    public static function getCustomClaims($email)
    {
        $user = static::getByEmail($email);
        if (! $user) {
            return [];
        }

        return [
            'can_manage_users'   => intval($user->can('manage-user')),
            'can_manage_records' => intval($user->can('manage-record')),
        ];
    }

    /**
     * returns user object, retrieved by email
     *
     * @param $email
     * @return User
     */
    public static function getByEmail($email)
    {
        return static::where('email', $email)->first();
    }


    /**
     * Describes relation between users and meals
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }


    /**
     * Checks if the user owns any kind of object
     *
     * @param $relation
     * @return bool
     */
    public function owns($relation)
    {
        return $relation->user_id == $this->id;
    }

    /**
     * Retrieves filtered user meals from DB
     * filter format:
     * [
     *   'date-from' => '2016-04-06',
     *   'date-to' => '2016-06-07',
     *   'time-from' => '04:30',
     *   'time-to' => '22:30',
     * ]
     *
     * @param array $filter
     * @return mixed
     */
    public function getMealsFilteredByDateTime(array $filter)
    {
        $cache_tag = 'meals_of_user_' . $this->id;
        $cache_id = $cache_tag . "_{$filter['date-from']}_{$filter['date-to']}";
        $meals = Cache::tags([$cache_tag])
            ->rememberForever($cache_id,
                function () use ($filter) {

                    return $this->meals()->where([
                        ['date', '>=', $filter['date-from']],
                        ['date', '<=', $filter['date-to']],
                    ])->orderBy('date', 'asc')->orderBy('time', 'asc')
                        ->get();

                });

        return $meals;
    }

    /**
     * Returns filtered user meals in output-ready format for the REST API
     * filter format:
     * [
     *   'date-from' => '2016-04-06',
     *   'date-to' => '2016-06-07',
     *   'time-from' => '04:30',
     *   'time-to' => '22:30',
     * ]
     *
     * @param array $filter
     * @return array
     */
    public function mealsFormattedOutput(array $filter)
    {
        $meals = $this->getMealsFilteredByDateTime($filter);

        $days = [];
        foreach ($meals as $meal) {
            if (! array_key_exists($meal['date'], $days)) {
                $days[$meal['date']] = [];
                $days[$meal['date']]['day_calories'] = 0;
                $days[$meal['date']]['meals'] = [];
            }

            $days[$meal['date']]['day_calories'] += $meal['calories'];
            if ($meal['time'] >= $filter['time-from'] &&
                $meal['time'] <= $filter['time-to']
            ) {
                $days[$meal['date']]['meals'][] = $meal;
            }
        }

        foreach ($days as $day => $dayData) {
            if (count($dayData['meals']) === 0) {
                unset($days[$day]);
            }
        }

        return [
            'user'       => $this->toArray(),
            'daily_data' => $days,
        ];
    }


    /**
     * Find current user's meal by ID
     * if meal does not exist, throws 404
     * if meal exists, but is owned by another user, throws 403
     *
     * @param int $id
     * @return mixed
     */
    public function findMealByIDOrFail($id)
    {
        $meal = Meal::find($id);
        if (! $meal) {
            abort(Response::HTTP_NOT_FOUND, 'Meal not found');
        }
        if ($meal->user_id != $this->id) {
            abort(Response::HTTP_FORBIDDEN, 'Access denied');
        }

        return $meal;
    }

    /**
     * Flushes cached meal queries for $this user
     *
     * @return $this
     */
    public function clearMealsCache()
    {
        $cache_tag = 'meals_of_user_' . $this->id;
        Cache::tags($cache_tag)->flush();

        return $this;
    }

}
