<?php
declare(strict_types=1);

namespace App\Services\AI\Providers\Azure\Request;

use App\Services\AI\Value\AiModel;
use App\Services\AI\Value\TokenUsage;

trait AzureUsageTrait
{
    /**
     * Extract usage information from Azure OpenAI response
     *
     * @param AiModel $model
     * @param array $data
     * @return TokenUsage|null
     */
    protected function extractUsage(AiModel $model, array $data): ?TokenUsage
    {
        error_log('ExtractUsage');
        if (empty($data['usage'])) {
            return null;
        }
        
        return new TokenUsage(
            model: $model,
            promptTokens: (int)$data['usage']['prompt_tokens'],
            completionTokens: (int)$data['usage']['completion_tokens'],
        );
    }
}