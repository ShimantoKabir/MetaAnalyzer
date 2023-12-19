<?php

namespace App\WebPage\Controllers;

use App\WebPage\Mappers\MetaAnalyzerRequestBuilder;
use App\WebPage\Services\WebpageService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use App\WebPage\Services\PreviewService;
use App\WebPage\Services\MetaAnalyzerService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Pagination\Paginator;

/**
 * @OA\Info(title="Meta data analyzer API", version="0.1")
 * @author  Shahariar Kabir <kabir3483@gmail.com>
 */
class MetaAnalyzerController extends Controller
{
    private MetaAnalyzerRequestBuilder $requestBuilder;
    private MetaAnalyzerService $metaAnalyzerService;
    private PreviewService $previewService;
    private WebpageService $webpageService;

    public function __construct(
        MetaAnalyzerRequestBuilder $requestBuilder,
        MetaAnalyzerService $metaAnalyzerService,
        PreviewService $previewService,
        WebpageService $webpageService
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->metaAnalyzerService = $metaAnalyzerService;
        $this->previewService = $previewService;
        $this->webpageService = $webpageService;
    }

    /**
     * Analyze meta data of a webpage
     *
     * @OA\Post(
     *  path="/api/webpages/analyze",
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
     *   path="/api/webpages/preview",
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

    /**
     * Get all webpage and metadata info with pagination
     *
     * @OA\Get (
     *   path="/api/webpages/paginate",
     *   tags={"Get all webpage and metadata"},
     *   operationId="webpage-metadata",
     *   @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page number",
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   )
     * )
     */
    public function getAllWebpages() : Paginator
    {
        return $this->webpageService->getAllWebpages();
    }

    /**
     * Update all metadata
     *
     * @OA\Get (
     *   path="/api/webpages/metadata/update-all",
     *   tags={"Update all metadata"},
     *   operationId="update-all-metadata",
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   )
     * )
     */
    public function updateAllMetadata() : JsonResponse
    {
        $this->metaAnalyzerService->updateAllMetadata();
        return response()->json("All metadata updated....!", Response::HTTP_OK);
    }

    /**
     * Display preview image by webpage id
     *
     * @OA\Get (
     *   path="/api/webpages/preview/{id}",
     *   tags={"Display preview image"},
     *   operationId="display-preview-image",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Webpage id",
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Bad Request"
     *   )
     * )
     */
    public function getPreviewById(int $id) : Factory|View
    {
        $previewImage = $this->webpageService->getPreviewImage($id);
        return view('preview', ['image' => $previewImage]);
    }
}
