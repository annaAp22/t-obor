<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
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
        DB::listen(function ($query){
            //dump($query->sql);
            //dump($query->bindings);

            //echo $query->sql."<br>";
            //echo "<pre>";
            //print_r($query->bindings)."<br>";
            //echo "</pre>";

        });

        Validator::extend('sysname', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9_-]+$/u', $value);
        });

        Validator::extend('youtube_code', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9_-]{11}$/u', $value);
        });

        Validator::extend('not_empty', function($attribute, $value, $parameters, $validator) {
            if(gettype($value) == 'array') {
                if(!empty($value) && !empty($value[0])) {
                    return true;
                }
            } elseif(!empty($value)) {
                return true;
            }
            return false;
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
