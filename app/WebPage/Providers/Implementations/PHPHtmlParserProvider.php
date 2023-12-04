<?php

namespace App\WebPage\Providers\Implementations;

use PHPHtmlParser\Dom;
use App\WebPage\Dtos\MetadataDto;
use App\WebPage\Providers\MetadataProvider;

class PHPHtmlParserProvider implements MetadataProvider
{

  function provideByURL(string $url): MetadataDto
  {
    $metadataDto = new MetadataDto();
    $metadataDto->totalDescription = 0;
    $metadataDto->httpEquivRefreshPresent = false;

    $dom = new Dom;
    $dom->loadFromUrl($url);

    $titles = $dom->find('title');
    $metadataDto->totalTile = count($titles);

    $metadataDto->title = $titles->firstChild()->text;

    $metaElements = $dom->find("meta");
    foreach ($metaElements as $element) {

      $charset = $element->getAttribute('charset');
      $httpEquiv = $element->getAttribute('http-equiv');

      if ($charset != null) {
        $metadataDto->charset = $charset;
      }

      if ($httpEquiv != null && $httpEquiv == "refresh") {
        $metadataDto->httpEquivRefreshPresent = true;
      }

      $name = $element->getAttribute('name');

      $content = $element->getAttribute('content');

      if ($name != null && $name == "description") {
        $metadataDto->description = $content;
        $metadataDto->totalDescription++;
      }

      if ($name != null && $name == "viewport") {
        $metadataDto->viewport = $content;
      }

      if ($name != null && $name == "robots") {
        $metadataDto->robots = $content;
      }
    }

    return $metadataDto;
  }
}
