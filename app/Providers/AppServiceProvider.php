<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('before_equal',
            function ($attribute, $value, $parameters, $validator) {
                return strtotime($validator->getData()[$parameters[0]]) >= strtotime($value);
            });

        Validator::replacer('before_equal',
            function ($message, $attribute, $rule, $parameters) {
                return str_replace(':date', $parameters[0], $message);
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
