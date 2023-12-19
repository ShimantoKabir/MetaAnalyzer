<?php

namespace App\WebPage\Mappers;

use App\WebPage\Dtos\WebpageDto;
use Illuminate\Http\Request;

class MetaAnalyzerRequestBuilder
{

  private WebpageMapper $webpageMapper;

  public function __construct(WebpageMapper $webPageMapper)
  {
    $this->webpageMapper = $webPageMapper;
  }

  public function toRequestDto(Request $request): WebpageDto
  {
    return $this->webpageMapper->requestToDto($request);
  }
}
