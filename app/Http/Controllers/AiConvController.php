<?php

namespace App\Http\Controllers;

use App\Models\AiConv;
use App\Models\AiConvMsg;
use App\Models\Attachment;
use App\Services\Chat\AiConv\AiConvService;
use App\Services\Chat\Attachment\AttachmentService;
use App\Services\Chat\Message\MessageContentValidator;
use App\Services\Chat\Message\MessageHandlerFactory;
use App\Services\Storage\FileStorageService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AiConvController extends Controller
{
    protected $aiConvService;
    protected $messageHandler;
    protected $contentValidator;
    protected $attachmentService;

    public function __construct(
            AttachmentService $attachmentService,
            AiConvService $aiConvService)
    {
        $this->aiConvService = $aiConvService;
        $this->messageHandler = app(MessageHandlerFactory::class)->create('private');
        $this->contentValidator = new MessageContentValidator();
        $this->attachmentService = $attachmentService;
    }


    ///CREATE NEW CONVERSATION
    public function create(Request $request): JsonResponse
    {
        error_log("=== FUNC 1 ===");
        $validatedData = $request->validate([
            'conv_name'     => 'nullable|string|max:255',
            'system_prompt' => 'nullable|string'
        ]);

        error_log("=== FUNC 2 ===");
        $conv = $this->aiConvService->create($validatedData);

        error_log("=== FUNC 2, return ===");
        return response()->json([
            'success' => true,
            'conv'    => $conv,
        ], 201);
    }


    /// RETURNS CONVERSATION DATA WHICH WILL BE DYNAMICALLY LOADED ON THE PAGE
    public function load($slug): JsonResponse
    {
        error_log("=== FUNC 3 ===");
        $convData = $this->aiConvService->load($slug);
        error_log("=== FUNC 3, return ===");
        return response()->json([
            'success' => true,
            'data' => $convData,
        ]);
    }


    public function update(Request $request, $slug): JsonResponse
    {
        error_log("=== FUNC 4 ===");
        $validatedData = $request->validate([
            'system_prompt' => 'string'
        ]);
        $this->aiConvService->update($validatedData, $slug);

        error_log("=== FUNC 4, return ===");
        return response()->json([
            'success' => true,
            'response' => "Info updated successfully",
        ]);
    }

    public function delete($slug): JsonResponse
    {
        error_log("=== FUNC 5 ===");
        $this->aiConvService->delete($slug);
        error_log("=== FUNC 5, return ===");
        return response()->json([
            'success' => true,
            'message' => 'Conv deleted successfully'
        ]);
    }


    public function sendMessage(Request $request, $slug, MessageContentValidator $contentValidator): JsonResponse {

        error_log("=== FUNC 6 ===");
        $validatedData = $request->validate([
            'isAi' => 'required|boolean',
            'threadId' => 'required|integer|min:0',
            'content' => 'required|array',
            'model' => 'string',
            'completion' => 'required|boolean',
        ]);
        error_log("=== FUNC 6, content ===");
        $validatedData['content'] = $contentValidator->validate($validatedData['content']);

        // CREATE MESSAGE
        error_log("=== FUNC 6, create message ===");
        $conv = AiConv::where('slug', $slug)->firstOrFail();
        $message = $this->messageHandler->create($conv, $validatedData);

        $messageData = $message->createMessageObject();
        error_log("=== FUNC 6 return ===");
        return response()->json([
            'success' => true,
            'messageData'=> $messageData
        ]);
    }



    public function updateMessage(Request $request, $slug, MessageContentValidator $contentValidator): JsonResponse {

        error_log("=== FUNC 7 ===");
        $validatedData = $request->validate([
            'isAi' => 'required|boolean',
            'content' => 'required|array',
            'model' => 'nullable|string',
            'completion' => 'required|boolean',
            'message_id' => 'required|string',
        ]);
        $validatedData['content'] = $contentValidator->validate($validatedData['content']);

        error_log("=== FUNC 7, slug ===");
        $conv = AiConv::where('slug', $slug)->firstOrFail();
        $message = $this->messageHandler->update($conv, $validatedData);
        $messageData = $message->toArray();
        $messageData['created_at'] = $message->created_at->format('Y-m-d+H:i');
        $messageData['updated_at'] = $message->updated_at->format('Y-m-d+H:i');

        error_log("=== FUNC 7, return ===");
        return response()->json([
            'success' => true,
            'messageData' => $messageData,
        ]);
    }

    public function deleteMessage(Request $request, $slug): JsonResponse {
        error_log("=== FUNC 8 ===");
        $validatedData = $request->validate([
            "message_id" => 'required|string|size:5'
        ]);

        error_log("=== FUNC 8, slug ===");
        $conv = AiConv::where('slug', $slug)->first();
        $deleted = $this->messageHandler->delete($conv, $validatedData);

        error_log("=== FUNC 8, return ===");
        return response()->json([
            'success'=> true,
        ]);


    }


    /// ATTACHMENT FUNCTIONS
    ///

    public function storeAttachment(Request $request): JsonResponse {
        error_log("=== FUNC 9 ===");
        $validateData = $request->validate([
            'file' => 'required|file|max:20480'
        ]);
        $result = $this->attachmentService->store($validateData['file'], 'private');
        error_log("=== FUNC 9, return ===");
        return response()->json($result);
    }

    /**
     * @throws Exception
     */
    public function getAttachmentUrl(Request $request, string $uuid): JsonResponse
    {

        error_log("=== FUNC 10 ===");
        $attachment = Attachment::where('uuid', $uuid)->firstOrFail();
        if($attachment->user->isNot(Auth::user())){
            throw new AuthorizationException();
        }
        $url = $this->attachmentService->getFileUrl($attachment, null);
        error_log("=== FUNC 10, return ===");
        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }


    public function downloadAttachment(string $uuid, string $path)
    {
        error_log("=== FUNC 11 ===");
        try {
            $attachment = Attachment::where('uuid', $uuid)->firstOrFail();
            if($attachment->user->isNot(Auth::user())){
                throw new AuthorizationException();
            }

            $storageService = app(FileStorageService::class);
            $stream = $storageService->streamFromSignedPath($path); // returns a resource
            error_log("=== FUNC 11, return ===");
            return response()->streamDownload(function () use ($stream)
            {
                fpassthru($stream); // send stream directly to browser
            },
                $attachment->filename,
                [
                    'Content-Type' => $attachment->mime,
                ]
            );
            error_log("=== FUNC 11, catch ===");
        } catch (FileNotFoundException $e) {
            abort(404, 'File not found');
        }
    }


    public function deleteAttachment(Request $request): JsonResponse {
        error_log("=== FUNC 12 ===");
        $validateData = $request->validate([
            'fileId' => 'required|string',
        ]);

        error_log("=== FUNC 12, uuid ===");
        try{
            $attachment = Attachment::where('uuid', $validateData['fileId'])->firstOrFail();

            error_log("=== FUNC 12, authorization ===");
            if ($attachment->user && !$attachment->user->is(Auth::user())) {
                throw new AuthorizationException();
            }

            error_log("=== FUNC 12, 2 ===");
            if (!$attachment->attachable instanceof AiConvMsg) {
                error_log("=== FUNC 12, return 1 ===");
                return response()->json([
                    'success'=> false,
                    'err'=> 'File Id does not match the properties!'
                ], 500);
            }

            $result = $this->attachmentService->delete($attachment);
            error_log("=== FUNC 12, return 2 ===");
            return response()->json([
                "success" => $result
            ]);
        }
        catch(Exception $e) {
            Log::error($e);
            throw $e;

        }
    }
}
