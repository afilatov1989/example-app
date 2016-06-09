<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    /**
     * returns Role object by it's name field or null if not found
     *
     * @param $name
     * @return static
     */
    public static function getByName($name)
    {
        return static::where('name', $name)->first();
    }
}