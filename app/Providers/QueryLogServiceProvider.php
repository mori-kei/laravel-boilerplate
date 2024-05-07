<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryLogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // @see https://stackoverflow.com/questions/41140975/laravel-eloquent-display-query-log
        DB::listen(function($query) {
            Log::debug(
                $query->sql,
                [
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]
            );
        });        
    }
}
