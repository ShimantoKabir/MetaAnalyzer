<?php

namespace App\WebPage\Mappers;

use App\WebPage\Dtos\MetadataDto;
use App\WebPage\Models\Metadata;

class MetadataMapper
{
  public function modelToDto(Metadata $metadata): MetadataDto
  {
    $metadataDto = new MetadataDto();

    $metadataDto->id = $metadata->id;
    $metadataDto->title = $metadata->title;
    $metadataDto->description = $metadata->description;
    $metadataDto->viewport = $metadata->viewport;
    $metadataDto->robots = $metadata->robots;
    $metadataDto->charset = $metadata->charset;
    $metadataDto->totalTile = $metadata->totalTile;
    $metadataDto->totalDescription = $metadata->totalDescription;
    $metadataDto->httpEquivRefreshPresent = $metadata->httpEquivRefreshPresent;
    $metadataDto->webpageId = $metadata->webpageId;

    return $metadataDto;
  }
}
