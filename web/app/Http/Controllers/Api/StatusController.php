<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * GET /api/v1/health: memastikan aplikasi hidup dan database bisa dihubungi.
 * Berguna untuk memantau website di hosting tanpa membuka cPanel.
 */
class StatusController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $mulai = microtime(true);
        $database = 'terhubung';

        try {
            DB::select('SELECT 1');
        } catch (Throwable $e) {
            $database = 'gagal';
            Log::error('[health] Database gagal: '.$e->getMessage());
        }

        return response()->json([
            'status' => $database === 'terhubung' ? 'ok' : 'gangguan',
            'layanan' => 'methodist_lubuk_pakam_web',
            'database' => $database,
            'waktu_ms' => (int) round((microtime(true) - $mulai) * 1000),
            'timestamp' => now()->toIso8601String(),
        ], $database === 'terhubung' ? 200 : 503);
    }
}
