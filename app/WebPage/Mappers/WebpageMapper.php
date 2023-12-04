<?php

namespace App\WebPage\mappers;

use App\WebPage\Dtos\WebpageDto;
use Illuminate\Http\Request;

class WebpageMapper
{
  public function requestToDto(Request $request): WebpageDto
  {
    $webPage = new WebpageDto();

    $object = json_decode($request->getContent());

    $url = $object->url;

    if (substr($url, -1) != "/") {
      $url = $url . "/";
    }

    $webPage->url = $url;
    return $webPage;
  }
}
