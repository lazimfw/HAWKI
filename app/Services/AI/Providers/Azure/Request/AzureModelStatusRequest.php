<?php
declare(strict_types=1);

namespace App\Services\AI\Providers\Azure\Request;

use App\Services\AI\Interfaces\ModelProviderInterface;
use App\Services\AI\Providers\AbstractRequest;
use App\Services\AI\Value\AiModelStatusCollection;
use App\Services\AI\Value\ModelOnlineStatus;
use Illuminate\Support\Facades\Http;

class AzureModelStatusRequest extends AbstractRequest
{
    public function __construct(
        private readonly ModelProviderInterface $provider
    )
    {
    }

    public function execute(AiModelStatusCollection $statusCollection): void
    {
        error_log('executeModelStatus');
        $statusCollection->setAllOnline();
        return;

        #obsolete code
        $pingUrl = $this->provider->getConfig()->getPingUrl();
        if ($pingUrl === null) {
            $statusCollection->setAllOnline();
            return;
        }

        try {
            $apiKey = $this->provider->getConfig()->getApiKey();
            
            $response = Http::withHeaders([
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(10)
            ->get($pingUrl);
            
            if ($response->successful()) {
                $statusCollection->setAllOnline();
            } else {
                $statusCollection->setAllOffline();
            }
            
        } catch (\Throwable $e) {
            $statusCollection->setAllOffline();
        }
    }
}