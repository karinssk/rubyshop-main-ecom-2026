<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthController extends Controller
{
    public function check()
    {
        $health = [
            'status' => 'ok',
            'timestamp' => now()->toISOString(),
            'server' => [
                'php_version' => PHP_VERSION,
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
                'peak_memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
            ],
            'checks' => []
        ];

        // Database check
        try {
            DB::select('SELECT 1');
            $health['checks']['database'] = 'ok';
        } catch (\Exception $e) {
            $health['checks']['database'] = 'error: ' . $e->getMessage();
            $health['status'] = 'degraded';
        }

        // Cache check
        try {
            Cache::put('health_check', 'ok', 60);
            $cacheResult = Cache::get('health_check');
            $health['checks']['cache'] = $cacheResult === 'ok' ? 'ok' : 'error';
        } catch (\Exception $e) {
            $health['checks']['cache'] = 'error: ' . $e->getMessage();
            $health['status'] = 'degraded';
        }

        // Storage check
        $health['checks']['storage'] = is_writable(storage_path()) ? 'ok' : 'error: not writable';
        
        if ($health['checks']['storage'] !== 'ok') {
            $health['status'] = 'degraded';
        }

        return response()->json($health);
    }
}
