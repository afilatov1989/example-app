<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'text',
        'calories',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    /**
     * Returns a user who created the record about this meal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    /**
     * Determine if the given user created the record about this meal
     *
     * @param User $user
     * @return mixed
     */
    public function ownedBy(User $user)
    {
        return $this->user_id == $user->id;
    }

}
