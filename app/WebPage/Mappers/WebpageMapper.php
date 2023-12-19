<?php

namespace App\WebPage\Mappers;

use App\WebPage\Dtos\WebpageDto;
use Illuminate\Http\Request;

class WebpageMapper
{
  public function requestToDto(Request $request): WebpageDto
  {
    $webPage = new WebpageDto();

    $object = json_decode($request->getContent());

    $url = $object->url;

    if (!str_ends_with($url, "/")) {
      $url = $url . "/";
    }

    $webPage->url = $url;
    return $webPage;
  }
}
