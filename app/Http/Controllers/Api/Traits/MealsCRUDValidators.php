<?php

namespace App\Http\Controllers\Api\Traits;

use Validator;

trait MealsCRUDValidators
{

    /**
     * Get a validator for meals list GET-request
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function indexValidator(array $data)
    {
        return Validator::make($data, [
            'date-from' => 'required|date_format:Y-m-d|regex:/\d{4}-\d{2}-\d{2}/|before_equal:date-to',
            'date-to'   => 'required|date_format:Y-m-d|regex:/\d{4}-\d{2}-\d{2}/',
            'time-from' => 'required|date_format:H:i|regex:/\d{2}:\d{2}/|before:time-to',
            'time-to'   => 'required|date_format:H:i|regex:/\d{2}:\d{2}/',
        ]);
    }

    /**
     * Get a validator for meal creating and updating requests
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createUpdateValidator(array $data)
    {
        return Validator::make($data, [
            'date'     => 'required|date_format:Y-m-d|regex:/\d{4}-\d{2}-\d{2}/',
            'time'     => 'required|date_format:H:i|regex:/\d{2}:\d{2}/',
            'text'     => 'required|min:6|max:10000',
            'calories' => 'required|integer|min:0|max:100000',
        ]);
    }

}