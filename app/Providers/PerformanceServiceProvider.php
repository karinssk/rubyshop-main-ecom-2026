<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Set execution time limit for long-running operations
        if (!app()->runningInConsole()) {
            set_time_limit(600); // 10 minutes for web requests
        }

        // Optimize database queries
        DB::listen(function ($query) {
            if ($query->time > 2000) { // Log slow queries (> 2 seconds)
                Log::warning('Slow query detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time . 'ms'
                ]);
            }
        });

        // Enable query result caching for production
        if (app()->environment('production')) {
            config(['database.connections.mysql.options' => [
                \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ]]);
        }
    }
}
