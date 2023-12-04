<?php

namespace App\WebPage\Services;

use App\WebPage\Dtos\WebpageDto;
use App\WebPage\Dtos\MetadataDto;
use Illuminate\Support\Facades\Log;
use App\WebPage\Dtos\AnalysisReportDto;
use App\WebPage\Mappers\MetadataMapper;
use App\WebPage\Providers\MetadataProvider;
use App\WebPage\Repositories\WebpageRepository;
use App\WebPage\Repositories\MetadataRepository;

class MetaAnalyzerService
{
  private MetadataProvider $metadataProvider;
  private WebpageRepository $webpageRepository;
  private MetadataRepository $metadataRepository;
  private MetadataMapper $metadataMapper;

  public function __construct(
    MetadataProvider $metadataProvider,
    WebpageRepository $webpageRepository,
    MetadataRepository $metadataRepository,
    MetadataMapper $metadataMapper
  ) {
    $this->metadataProvider = $metadataProvider;
    $this->webpageRepository = $webpageRepository;
    $this->metadataRepository = $metadataRepository;
    $this->metadataMapper = $metadataMapper;
  }

  public function analyzeMetaData(WebpageDto $webpageDto): AnalysisReportDto
  {
    $webpage = $this->webpageRepository->findWebpageByURL($webpageDto->url);

    if ($webpage == null) {
      $metadataDto = $this->metadataProvider->provideByURL($webpageDto->url);

      $webpage = $this->webpageRepository->saveWebpage($webpageDto);
      $metadataDto->webpageId = $webpage->id;

      $this->metadataRepository->save($metadataDto);

      Log::info("Webpage not found!");
      return $this->generateAnalysisReport($metadataDto);
    }

    if ($webpage->metadata == null) {
      $metadataDto = $this->metadataProvider->provideByURL($webpageDto->url);
      $metadataDto->webpageId = $webpage->id;

      $this->metadataRepository->save($metadataDto);

      Log::info("Webpage found but metadata not found!");
      return $this->generateAnalysisReport($metadataDto);
    }

    Log::info("Webpage and metadata both found!");
    return $this->generateAnalysisReport($this->metadataMapper->modelToDto($webpage->metadata));
  }

  function updateAllMetadata()
  {
    $webpages = $this->webpageRepository->findAll();

    foreach ($webpages as $webpage) {
      if ($webpage->metadata != null) {
        $metadataDto = $this->metadataProvider->provideByURL($webpage->url);
        $metadataDto->webpageId = $webpage->id;
        $this->metadataRepository->edit($metadataDto, $webpage->metadata);
        Log::info("Metadata update by CRON Job!");
      }
    }
  }

  function generateAnalysisReport(MetadataDto $metadataDto): AnalysisReportDto
  {

    $analysisReport = new AnalysisReportDto();

    if ($metadataDto->title == null) {
      array_push($analysisReport->issues, "No title found!");
    }

    if ($metadataDto->title != null && $this->isRepeatingWordFound($metadataDto->title)) {
      array_push($analysisReport->issues, "Repeated word found in title!");
    }

    if ($metadataDto->description == null) {
      array_push($analysisReport->issues, "No description found!");
    }

    if ($metadataDto->description != null && $this->isRepeatingWordFound($metadataDto->description)) {
      array_push($analysisReport->issues, "Repeated word found in description!");
    }

    if ($metadataDto->viewport == null) {
      array_push($analysisReport->issues, "No viewport found!");
    }

    if ($metadataDto->robots == null) {
      array_push($analysisReport->issues, "No robots text found!");
    }

    if ($metadataDto->charset == null) {
      array_push($analysisReport->issues, "No charset found!");
    }

    if ($metadataDto->totalTile > 1) {
      array_push($analysisReport->issues, "Title mentioned more than one!");
    }

    if ($metadataDto->totalDescription > 1) {
      array_push($analysisReport->issues, "Description mentioned more than one!");
    }

    if ($metadataDto->httpEquivRefreshPresent == true) {
      array_push($analysisReport->issues, "Page shouldn't refresh more than one!");
    }

    $analysisReport->isIssueFound = count($analysisReport->issues) == 0 ? false : true;
    $analysisReport->message = count($analysisReport->issues) == 0 ? "No issue found!" : "Issue found!";

    Log::info("SEO issue report generated!");
    return $analysisReport;
  }

  function isRepeatingWordFound(string $str): bool
  {
    $words = explode(' ', trim($str));

    if (count(array_unique($words)) == count($words)) {
      return false;
    }

    return true;
  }
}
