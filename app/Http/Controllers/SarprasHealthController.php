<?php

namespace App\Http\Controllers;

use App\Services\SarprasClient;
use Illuminate\Http\Request;

class SarprasHealthController extends Controller
{
    public function show(Request $request, SarprasClient $api)
    {
        $ok = false;
        $error = null;
        $latencyMs = null;
        $samples = [];

        $t0 = microtime(true);
        try {
            // panggil listBooks minimal (1 item) untuk test token+url
            $resp = $api->listBooks(['per_page' => 1]);
            $ok = true;
            $samples = $resp['data'] ?? [];
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        } finally {
            $latencyMs = (int) round((microtime(true) - $t0) * 1000);
        }

        $config = [
            'base_url' => config('sarpras.base_url'),
            'token_set' => config('sarpras.token') ? 'YES' : 'NO', // jangan tampilkan token real
            'timeout'  => config('sarpras.timeout'),
            'retry'    => config('sarpras.retry'),
        ];

        return view('health.sarpras', compact('ok', 'error', 'latencyMs', 'config', 'samples'));
    }
}
