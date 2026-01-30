<?php
declare(strict_types=1);


namespace App\Services\AI;


use App\Services\AI\Exception\ModelIdNotAvailableException;
use App\Services\AI\Exception\ModelNotInPayloadException;
use App\Services\AI\Exception\NoModelSetInRequestException;
use App\Services\AI\Value\AiModel;
use App\Services\AI\Value\AiRequest;
use App\Services\AI\Value\AiResponse;
use App\Services\AI\Value\AvailableAiModels;
use App\Services\AI\Value\ModelUsageType;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
readonly class AiService
{
    public function __construct(
        private AiFactory $factory
    )
    {
    }
    
    /**
     * Get a list of all available models
     *
     * @param bool|null $external Set this to true, to receive the models enabled for external applications.
     *                           If null, the default models will be returned.
     */
    public function getAvailableModels(?bool $external = null): AvailableAiModels
    {
        error_log("=== FUNC 1 ===");
        $usageType = $external ? ModelUsageType::EXTERNAL_APP : ModelUsageType::DEFAULT;
        return $this->factory->getAvailableModels($usageType);
    }
    
    /**
     * Get a specific model by its ID
     *
     * @param string $modelId The model ID to retrieve
     * @param bool|null $external Set this to true, to receive the models enabled for external applications.
     *                           If null, the default models will be returned.
     * @return AiModel|null
     */
    public function getModel(string $modelId, ?bool $external = null): ?AiModel
    {
        error_log("=== FUNC 2 ===");
        return $this->getAvailableModels($external)->models->getModel($modelId);
    }
    
    /**
     * Get a specific model by its ID or throw an exception if not found
     *
     * @param string $modelId The model ID to retrieve
     * @param bool|null $external Set this to true, to receive the models enabled for external applications.
     *                           If null, the default models will be returned.
     * @return AiModel
     * @throws ModelIdNotAvailableException
     */
    public function getModelOrFail(string $modelId, ?bool $external = null): AiModel
    {
        error_log("=== FUNC 3 ===");
        $model = $this->getModel($modelId, $external);
        if (!$model) {
            throw new ModelIdNotAvailableException($modelId);
        }
        error_log("=== FUNC 3, return ===");
        return $model;
    }
    
    /**
     * Sends an AI request to the appropriate model client.
     * The request will be handled without streaming; meaning the full response will be returned at once.
     *
     * @param array|AiRequest $request Either an AiRequest object or an array representing the request payload.
     * @return AiResponse
     */
    public function sendRequest(array|AiRequest $request): AiResponse
    {
        error_log("=== FUNC 4 ===");
        [$request, $model] = $this->resolveRequestAndModel($request);
        return $model->getClient()->sendRequest($request);
    }
    
    /**
     * Sends an AI request to the appropriate model client with streaming support.
     * The response will be delivered in chunks via the provided callback function.
     *
     * @param array|AiRequest $request Either an AiRequest object or an array representing the request payload.
     * @param callable(AiResponse $response): void $onData A callback function that will be called with each chunk of data received.
     *                         The function should accept a single parameter of type AiResponse.
     * @return void
     */
    public function sendStreamRequest(array|AiRequest $request, callable $onData): void
    {
        error_log("=== FUNC 5 ===");
        [$request, $model] = $this->resolveRequestAndModel($request);
        $model->getClient()->sendStreamRequest($request, $onData);
    }
    
    /**
     * Helper to resolve the request and model object based on the provided input.
     * @param array|AiRequest $request
     * @return array{0: AiRequest, 1: AiModel}
     */
    private function resolveRequestAndModel(array|AiRequest $request): array
    {
        error_log("=== FUNC 6 ===");
        if (is_array($request)) {
            $modelId = $request['model'] ?? null;
            error_log("=== FUNC 6: Array request, model ===");
            if (empty($modelId)) {
                error_log("=== FUNC 6: Model not in payload ===");
                throw new ModelNotInPayloadException($request);
            }
            $model = $this->getModelOrFail($modelId);
            $request = new AiRequest(payload: $request);
            return [$request, $model];
        }
        
        error_log("=== FUNC 6: AiRequest object, model ===");
        if ($request->model === null) {
            error_log("=== FUNC 6: last ===");
            throw new NoModelSetInRequestException();
        }
        
        return [$request, $request->model];
    }
}
