<?php

return [
    'base_url' => env('AI_EXTRACTION_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
    'api_key' => env('GEMINI_API_KEY'),
    'model' => env('AI_EXTRACTION_MODEL', 'gemini-3-flash-preview'),
    'disk' => env('AI_EXTRACTION_DISK', 'local'),
    'timeout' => (int) env('AI_EXTRACTION_TIMEOUT', 90),
];
