<?php

namespace App\WebPage\mappers;

use App\WebPage\Dtos\WebpageDto;
use App\WebPage\mappers\WebPageMapper;
use Illuminate\Http\Request;

class MetaAnalyzerRequestBuilder
{

  private WebPageMapper $webPageMapper;

  public function __construct(WebPageMapper $webPageMapper)
  {
    $this->webPageMapper = $webPageMapper;
  }

  public function toRequestDto(Request $request): WebpageDto
  {
    return $this->webPageMapper->requestToDto($request);
  }
}
