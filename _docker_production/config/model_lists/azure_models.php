<?php
return [
    [
        'active' => env('MODELS_AZURE_GPT_5_1_CHAT_ACTIVE', true),
        'id' => 'gpt-5.1-chat',
        'label' => 'Azure GPT 5.1 Chat',
        "input" => [
            "text",
            "image"
        ],
        "output" => [
            "text"
        ],
        'tools' => [
            'stream' => true,
            'vision' => env('MODELS_AZURE_GPT_5_1_CHAT_TOOLS_VISION', true),
            'file_upload' => env('MODELS_AZURE_GPT_5_1_CHAT_TOOLS_FILE_UPLOAD', false),
            'function_calling' => env('MODELS_AZURE_GPT_5_1_CHAT_TOOLS_FUNCTION_CALLING', true),
            'json_mode' => env('MODELS_AZURE_GPT_5_1_CHAT_TOOLS_JSON_MODE', true),
        ],
        'azure_deployment' => env('MODELS_AZURE_GPT_5_1_CHAT_DEPLOYMENT', 'gpt-5-1-chat'),
        'azure_endpoint_type' => 'https://forschung-und-praktikum.openai.azure.com/openai/responses?api-version=2025-04-01-preview',
        'max_tokens' => 16384,
    ],
    [
        'active' => env('MODELS_AZURE_GPT_4O_MINI_ACTIVE', true),
        'id' => 'gpt-4o-mini',
        'label' => 'Azure GPT-4o Mini',
        "input" => [
            "text",
            "image"
        ],
        "output" => [
            "text"
        ],
        'tools' => [
            'stream' => true,
            'vision' => env('MODELS_AZURE_GPT_4O_MINI_TOOLS_VISION', true),
            'file_upload' => env('MODELS_AZURE_GPT_4O_MINI_TOOLS_FILE_UPLOAD', false),
            'function_calling' => env('MODELS_AZURE_GPT_4O_MINI_TOOLS_FUNCTION_CALLING', true),
            'json_mode' => env('MODELS_AZURE_GPT_4O_MINI_TOOLS_JSON_MODE', true),
        ],
        'azure_deployment' => env('MODELS_AZURE_GPT_4O_MINI_DEPLOYMENT', 'gpt-4o-mini'),
        'azure_endpoint_type' => 'https://forschung-und-praktikum.openai.azure.com/openai/deployments/gpt-4o-mini/chat/completions?api-version=2025-01-01-preview',
        'max_tokens' => 16384,
    ],
    [
        'active' => env('MODELS_AZURE_O3_MINI_ACTIVE', true),
        'id' => 'o3-mini',
        'label' => 'Azure o3-mini',
        "input" => [
            "text"
        ],
        "output" => [
            "text"
        ],
        'tools' => [
            'stream' => true,
            'vision' => false,
            'file_upload' => false,
            'function_calling' => env('MODELS_AZURE_O3_MINI_TOOLS_FUNCTION_CALLING', true),
            'reasoning' => env('MODELS_AZURE_O3_MINI_TOOLS_REASONING', true),
            'json_mode' => env('MODELS_AZURE_O3_MINI_TOOLS_JSON_MODE', true),
        ],
        'azure_deployment' => env('MODELS_AZURE_O3_MINI_DEPLOYMENT', 'o3-mini'),
        'azure_endpoint_type' => 'https://forschung-und-praktikum.openai.azure.com/openai/deployments/o3-mini/chat/completions?api-version=2025-01-01-preview',
        'max_tokens' => 100000,
        'reasoning_effort' => env('MODELS_AZURE_O3_MINI_REASONING_EFFORT', 'medium'), 
    ],
];