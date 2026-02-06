<?php

namespace App\Services\AI\Providers\Azure;

use App\Models\Attachment;
use App\Services\AI\Utils\MessageAttachmentFinder;
use App\Services\AI\Value\AiModel;
use App\Services\AI\Value\AiRequest;
use App\Services\Chat\Attachment\AttachmentService;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Facades\Log;

#[Singleton]
readonly class AzureRequestConverter
{
    public function __construct(
        private MessageAttachmentFinder $attachmentFinder
    )
    {
    }

    public function convertRequestToPayload(AiRequest $request): array
    {
        error_log('ConvReqToPayLoad');
        $rawPayload = $request->payload;
        $model = $request->model;
        $messages = $rawPayload['messages'];
        $modelId = $rawPayload['model'];

        if ($modelId === 'gpt-5.1-chat') {
            return $this->convertGpt5Payload($request);
        }

        $messages = $this->handleModelSpecificFormatting($modelId, $messages);

        $attachmentsMap = $this->attachmentFinder->findAttachmentsOfMessages($messages);

        $formattedMessages = [];
        foreach ($messages as $message) {
            $formattedMessages[] = $this->formatMessage($message, $attachmentsMap, $model);
        }

        $payload = [
            'messages' => $formattedMessages,
            'stream' => $rawPayload['stream'] && $model->hasTool('stream'),
        ];

        if (isset($rawPayload['temperature'])) {
            $payload['temperature'] = $rawPayload['temperature'];
        }

        if (isset($rawPayload['top_p'])) {
            $payload['top_p'] = $rawPayload['top_p'];
        }

        if (isset($rawPayload['frequency_penalty'])) {
            $payload['frequency_penalty'] = $rawPayload['frequency_penalty'];
        }

        if (isset($rawPayload['presence_penalty'])) {
            $payload['presence_penalty'] = $rawPayload['presence_penalty'];
        }

        if (isset($rawPayload['max_tokens'])) {
            $payload['max_tokens'] = $rawPayload['max_tokens'];
        }

        if (isset($rawPayload['response_format'])) {
            $payload['response_format'] = $rawPayload['response_format'];
        }

        return $payload;
    }

  private function convertGpt5Payload(AiRequest $request): array
{
    error_log('Converting GPT-5.1');
    $rawPayload = $request->payload;
    $model = $request->model;
    $messages = $rawPayload['messages'];

    $formattedMessages = [];
    foreach ($messages as $message) {
        $role = $message['role'];
        $content = $message['content'] ?? [];
        $text = $content['text'] ?? '';

        if (str_contains($text, 'INTERNAL ERROR:')) {
            error_log('Skipping error message: ' . substr($text, 0, 100));
            continue;
        }

        if ($role === 'user') {
            $formattedMessages[] = [
                'role' => 'user',
                'content' => $text,
            ];
        } elseif ($role === 'assistant' || $role === 'system') {
            $formattedMessages[] = [
                'role' => 'assistant',
                'content' => [[
                    'type' => 'output_text',
                    'text' => $text,
                ]],
            ];
        }
    }

    if (empty($formattedMessages)) {
        $formattedMessages[] = [
            'role' => 'user',
            'content' => 'Hello',
        ];
    }

    $payload = [
        'model' => 'gpt-5.1-chat',
        'input' => $formattedMessages,
        'stream' => $rawPayload['stream'] && $model->hasTool('stream'),
    ];

    if (isset($rawPayload['temperature'])) {
        $payload['temperature'] = $rawPayload['temperature'];
    }

    if (isset($rawPayload['max_tokens'])) {
        $payload['max_tokens'] = $rawPayload['max_tokens'];
    }

    error_log('GPT-5.1: ' . json_encode($payload, JSON_PRETTY_PRINT));
    return $payload;
}

    private function formatMessage(array $message, array $attachmentsMap, AiModel $model): array
    {
        error_log('FormatMessage');
        $formatted = [
            'role' => $message['role'],
            'content' => []
        ];

        $content = $message['content'] ?? [];

        if (!empty($content['text'])) {
            $formatted['content'][] = [
                'type' => 'text',
                'text' => $content['text'],
            ];
        }

        if (!empty($content['attachments'])) {
            $this->processAttachments($content['attachments'], $attachmentsMap, $model, $formatted['content']);
        }

        return $formatted;
    }

    private function processAttachments(array $attachmentUuids, array $attachmentsMap, AiModel $model, array &$content): void
    {
        error_log('ProcessAttachment');
        $attachmentService = app(AttachmentService::class);
        $skippedAttachments = [];

        foreach ($attachmentUuids as $uuid) {
            $attachment = $attachmentsMap[$uuid] ?? null;
            if (!$attachment) {
                continue; 
            }

            switch ($attachment->type) {
                case 'image':
                    if ($model->canProcessImage()) {
                        $content[] = $this->processImageAttachment($attachment, $attachmentService);
                    } else {
                        $skippedAttachments[] = $attachment->name . ' (image not supported)';
                    }
                    break;

                case 'document':
                    if ($model->canProcessDocument()) {
                        $content[] = $this->processDocumentAttachment($attachment, $attachmentService);
                    } else {
                        $skippedAttachments[] = $attachment->name . ' (file upload not supported)';
                    }
                    break;

                default:
                    Log::warning('Unknown attachment type: ' . $attachment->type);
                    $skippedAttachments[] = $attachment->name . ' (unsupported type)';
                    break;
            }
        }

        if (!empty($skippedAttachments)) {
            $content[] = [
                'type' => 'text',
                'text' => '[NOTE: The following attachments were not included because this model does not support them: ' . implode(', ', $skippedAttachments) . ']'
            ];
        }
    }

    private function processImageAttachment(Attachment $attachment, AttachmentService $attachmentService): array
    {
        error_log('ProcesssImageAttachment');
        try {
            $url = $attachmentService->getFileUrl($attachment);
            return [
                'type' => 'image_url',
                'image_url' => [
                    'url' => $url,
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Failed to process image attachment: ' . $e->getMessage());
            return [
                'type' => 'text',
                'text' => '[ERROR: Could not process image attachment: ' . $attachment->name . ']'
            ];
        }
    }

    private function processDocumentAttachment(Attachment $attachment, AttachmentService $attachmentService): array
    {
        error_log('ProcessDocAttachment');
        try {
            $fileContent = $attachmentService->retrieve($attachment, 'md');
            $html_safe = htmlspecialchars($fileContent, ENT_QUOTES, 'UTF-8');
            return [
                'type' => 'text',
                'text' => "[ATTACHED FILE: {$attachment->name}]\n---\n{$html_safe}\n---"
            ];
        } catch (\Exception $e) {
            Log::error('Failed to process document attachment: ' . $e->getMessage());
            return [
                'type' => 'text',
                'text' => '[ERROR: Could not process document attachment: ' . $attachment->name . ']'
            ];
        }
    }

    /**
     * Handle special formatting requirements for specific Azure models
     *
     * @param string $modelId
     * @param array $messages
     * @return array
     */
    protected function handleModelSpecificFormatting(string $modelId, array $messages): array
    {
        error_log('HandleModelSpecificFromatting');
        return $messages;
    }
}