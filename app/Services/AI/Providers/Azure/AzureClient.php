<?php
declare(strict_types=1);

namespace App\Services\AI\Providers\Azure;

use App\Services\AI\Providers\AbstractClient;
use App\Services\AI\Providers\Azure\Request\AzureModelStatusRequest;
use App\Services\AI\Providers\Azure\Request\AzureNonStreamingRequest;
use App\Services\AI\Providers\Azure\Request\AzureStreamingRequest;
use App\Services\AI\Value\AiModelStatusCollection;
use App\Services\AI\Value\AiRequest;
use App\Services\AI\Value\AiResponse;

class AzureClient extends AbstractClient
{
    public function __construct(
        private readonly AzureRequestConverter $converter
    )
    {
    }
    
    /**
     * @inheritDoc
     */
    protected function executeRequest(AiRequest $request): AiResponse
    {
        error_log("Request check");
        return (new AzureNonStreamingRequest(
            $this->converter->convertRequestToPayload($request)
        ))->execute($request->model);
    }
    
    /**
     * @inheritDoc
     */
    protected function executeStreamingRequest(AiRequest $request, callable $onData): void
    {
        error_log("Streaming Request check");
        (new AzureStreamingRequest(
            $this->converter->convertRequestToPayload($request),
            $onData
        ))->execute($request->model);
        error_log(print_r($request->payload,true));
    }
    
    /**
     * @inheritDoc
     */
    protected function resolveStatusList(AiModelStatusCollection $statusCollection): void
    {
        error_log("Resolve Status check");
        (new AzureModelStatusRequest($this->provider))->execute($statusCollection);
    }
}
