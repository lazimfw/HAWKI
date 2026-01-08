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
        'max_tokens' => 100000,
        'reasoning_effort' => env('MODELS_AZURE_O3_MINI_REASONING_EFFORT', 'medium'), 
    ],
    [
        'active' => env('MODELS_AZURE_DALL_E_3_ACTIVE', true),
        'id' => 'dall-e-3',
        'label' => 'Azure DALL-E 3',
        "input" => [
            "text"
        ],
        "output" => [
            "image"
        ],
        'tools' => [
            'stream' => false,
            'vision' => false,
            'file_upload' => false,
            'image_generation' => true,
            'image_quality' => env('MODELS_AZURE_DALL_E_3_IMAGE_QUALITY', 'standard'), 
            'image_style' => env('MODELS_AZURE_DALL_E_3_IMAGE_STYLE', 'vivid'), 
            'image_size' => env('MODELS_AZURE_DALL_E_3_IMAGE_SIZE', '1024x1024'), 
        ],
        'azure_deployment' => env('MODELS_AZURE_DALL_E_3_DEPLOYMENT', 'dall-e-3'),
        'max_tokens' => 4000,
    ],
    [
        'active' => env('MODELS_AZURE_TEXT_EMBEDDING_3_LARGE_ACTIVE', true),
        'id' => 'text-embedding-3-large',
        'label' => 'Azure Text Embedding 3 Large',
        "input" => [
            "text"
        ],
        "output" => [
            "embedding"
        ],
        'tools' => [
            'stream' => false,
            'vision' => false,
            'file_upload' => false,
            'embedding' => true,
            'dimensions' => env('MODELS_AZURE_TEXT_EMBEDDING_3_LARGE_DIMENSIONS', 3072), 
            'encoding_format' => env('MODELS_AZURE_TEXT_EMBEDDING_3_LARGE_ENCODING_FORMAT', 'float'),
        ],
        'azure_deployment' => env('MODELS_AZURE_TEXT_EMBEDDING_3_LARGE_DEPLOYMENT', 'text-embedding-3-large'),
        'max_tokens' => 8191,
    ],
];