<?php
declare(strict_types=1);

namespace App\Services\AI\Providers\Azure\Request;

use App\Services\AI\Providers\AbstractRequest;
use App\Services\AI\Value\AiModel;
use App\Services\AI\Value\AiResponse;
use App\Services\AI\Providers\Azure\AzureUrlService;

class AzureStreamingRequest extends AbstractRequest
{
    use AzureUsageTrait;
    
    public function __construct(
        private array    $payload,
        private \Closure $onData
    )
    {
    }
    
    public function execute(AiModel $model): void
    {
        error_log('executeStreaming');
        $this->payload['stream'] = true;
        if ($model->getId() !== 'gpt-5.1-chat') {
        $this->payload['stream_options'] = [
            'include_usage' => true,
        ];
        }

        $dynamicUrl = AzureUrlService::getUrlForModel($model->getId());
        error_log('Using dynamic URL: ' . $dynamicUrl);
        
        $this->executeStreamingRequest(
            model: $model,
            payload: $this->payload,
            onData: $this->onData,
            chunkToResponse: [$this, 'chunkToResponse'],
            apiUrl: $dynamicUrl
        );
    }
    
    protected function chunkToResponse(AiModel $model, string $chunk): AiResponse
    {
        error_log('ChunkToResponse');
        if ($model->getId() === 'gpt-5.1-chat') {
        return $this->parseGpt5Chunk($chunk, $model);
    }
        $jsonChunk = json_decode($chunk, true, 512, JSON_THROW_ON_ERROR);
        
        if (isset($jsonChunk['error'])) {
            return $this->createErrorResponse($jsonChunk['error']['message'] ?? 'Unknown error');
        }
        
        $content = '';
        $isDone = false;
        $usage = null;
        
        // Check for the finish_reason flag
        if (isset($jsonChunk['choices'][0]['finish_reason']) && $jsonChunk['choices'][0]['finish_reason'] === 'stop') {
            $isDone = true;
        }
        
        // Extract usage data if available
        if (!empty($jsonChunk['usage'])) {
            $usage = $this->extractUsage($model, $jsonChunk);
        }
        
        // Extract content if available
        if (isset($jsonChunk['choices'][0]['delta']['content'])) {
            $content = $jsonChunk['choices'][0]['delta']['content'];
        }
        
        return new AiResponse(
            content: [
                'text' => $content,
            ],
            usage: $usage,
            isDone: $isDone
        );
    }

    private function parseGpt5Chunk(string $chunk, AiModel $model): AiResponse
    {
    error_log('gpt-5.1 CHUNK : ' . substr($chunk, 0, 200));
    $jsonChunk = json_decode($chunk, true);
    
    if (!$jsonChunk) {
        return new AiResponse(
            content: ['text' => ''],
            isDone: false
        );
    }

    if (isset($jsonChunk['error'])) {
        return $this->createErrorResponse($jsonChunk['error']['message'] ?? 'Unknown error');
    }
    
    $content = '';
    $isDone = false;
    
    // GPT-5.1 response format
    $type = $jsonChunk['type'] ?? '';
    
    switch ($type) {
        case 'response.output_text.delta':
            $content = $jsonChunk['delta'] ?? '';
            error_log('GPT-5.1 DELTA: "' . $content . '"');
            break;
            
        case 'response.output_text.done':
            $content = $jsonChunk['text'] ?? '';
            error_log('GPT-5.1 FINAL TEXT: "' . $content . '"');
            break;
            
        case 'response.completed':
            $isDone = true;
            error_log('GPT-5.1 STREAM COMPLETED');
            break;
            
        default:
            $content = '';
            break;
    }
    
    return new AiResponse(
        content: [
            'text' => $content,
        ],
        isDone: $isDone
    );
    }
}