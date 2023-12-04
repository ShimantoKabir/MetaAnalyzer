<?php

namespace App\WebPage\Services;

use App\WebPage\Dtos\WebpageDto;
use App\WebPage\Providers\PreviewProvider;
use App\WebPage\Repositories\WebpageRepository;
use Illuminate\Support\Facades\Log;

class PreviewService
{

  private PreviewProvider $previewProvider;
  private WebpageRepository $webpageRepository;

  public function __construct(
    PreviewProvider $previewProvider,
    WebpageRepository $webpageRepository,
  ) {
    $this->previewProvider = $previewProvider;
    $this->webpageRepository = $webpageRepository;
  }

  function createPreview(WebpageDto $webpageDto): string
  {

    $webpage = $this->webpageRepository->findWebpageByURL($webpageDto->url);

    if ($webpage == null) {
      $previewImage = $this->previewProvider->providePreviewImage($webpageDto->url);
      $webpageDto->previewImage = $previewImage;
      $this->webpageRepository->saveWebpage($webpageDto);
      Log::info("Create a new webpage and saved the preview image!");
      return $previewImage;
    }

    if ($webpage->previewImage == null) {
      $previewImage = $this->previewProvider->providePreviewImage($webpageDto->url);
      $webpageDto->previewImage = $previewImage;
      $this->webpageRepository->editWebpage($webpageDto, $webpage);
      Log::info("Webpage exist, but preview image not, created a new preview image and save it to exist webpage table!");
      return $previewImage;
    }

    Log::info("Preview image loaded from database!");
    return $webpage->previewImage;
  }
}
