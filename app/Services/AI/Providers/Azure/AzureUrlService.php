<?php

namespace App\Services\AI\Providers\Azure;

class AzureUrlService
{
    private static $urls = [
        'gpt-5.1-chat' => 'https://forschung-und-praktikum.openai.azure.com/openai/responses?api-version=2025-04-01-preview',
        'gpt-4o-mini' => 'https://forschung-und-praktikum.openai.azure.com/openai/deployments/gpt-4o-mini/chat/completions?api-version=2025-01-01-preview',
        'o3-mini' => 'https://forschung-und-praktikum.openai.azure.com/openai/deployments/o3-mini/chat/completions?api-version=2025-01-01-preview',
     ];
    
    public static function getUrlForModel(string $modelId): string
    {
        return self::$urls[$modelId] ?? self::$urls['o3-mini'];
    }
}