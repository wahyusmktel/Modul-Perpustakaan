<?php

return [
    'base_url'     => env('SARPRAS_API_URL', 'http://localhost/api'),
    'token'        => env('SARPRAS_API_TOKEN', ''),
    'timeout'      => (int) env('SARPRAS_TIMEOUT', 10),
    'retry'        => (int) env('SARPRAS_RETRY', 2),
    'retry_delay'  => (int) env('SARPRAS_RETRY_DELAY', 200), // milliseconds
];
