<?php

namespace App\WebPage\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\WebPage\Services\PreviewService;
use App\WebPage\Services\MetaAnalyzerService;
use Symfony\Component\HttpFoundation\Response;
use App\WebPage\mappers\MetaAnalyzerRequestBuilder;

/**
 * @OA\Info(title="Meta data analyzer API", version="0.1")
 * @author  Shahariar Kabir <kabir3483@gmail.com>
 */
class MetaAnalyzerController extends Controller
{
    private MetaAnalyzerRequestBuilder $requestBuilder;
    private MetaAnalyzerService $metaAnalyzerService;
    private PreviewService $previewService;

    public function __construct(
        MetaAnalyzerRequestBuilder $requestBuilder,
        MetaAnalyzerService $metaAnalyzerService,
        PreviewService $previewService
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->metaAnalyzerService = $metaAnalyzerService;
        $this->previewService = $previewService;
    }

    /**
     * Analyze meta data of a webpage
     *
     * @OA\Post(
     *  path="/MetaAnalyzer/public/api/webpage/analyze",
     *  tags={"Analyze Meta Data"},
     *  operationId="analyze-metadata",
     *  @OA\Response(
     *    response=400,
     *    description="Bad Request"
     *  ),
     *  @OA\RequestBody(
     *    description="Analyze webpage meta data",
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/WebpageDto")
     *  )
     * )
     */
    public function analyzeMetaData(Request $request): JsonResponse
    {
        $webpageDto = $this->requestBuilder->toRequestDto($request);
        $analysisReport = $this->metaAnalyzerService->analyzeMetaData($webpageDto);
        return response()->json($analysisReport, Response::HTTP_OK);
    }

    /**
     * Create preview image of a webpage
     *
     * @OA\Post(
     *   path="/MetaAnalyzer/public/api/webpage/preview",
     *   tags={"Create Preview Image"},
     *   operationId="preview-image",
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   ),
     *   @OA\RequestBody(
     *     description="Create preview image",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/WebpageDto")
     *   )
     * )
     */
    public function createPreview(Request $request): Factory|View
    {
        $webpageDto = $this->requestBuilder->toRequestDto($request);
        $imageString = $this->previewService->createPreview($webpageDto);
        return view('preview', ['image' => $imageString]);
    }
}
