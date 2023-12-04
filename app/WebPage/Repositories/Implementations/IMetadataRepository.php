<?php

namespace App\WebPage\Repositories\Implementations;

use App\WebPage\Dtos\MetadataDto;
use App\WebPage\Models\Metadata;
use App\WebPage\Repositories\MetadataRepository;

class IMetadataRepository implements MetadataRepository
{
  function save(MetadataDto $metadataDto): Metadata
  {
    $metadata = new Metadata();
    return $this->saveOrUpdate($metadataDto, $metadata);
  }

  function edit(MetadataDto $metadataDto, Metadata $metadata): Metadata
  {
    return $this->saveOrUpdate($metadataDto, $metadata);
  }

  function saveOrUpdate(MetadataDto $metadataDto, Metadata $metadata): Metadata
  {
    $metadata->title = $metadataDto->title;
    $metadata->description = $metadataDto->description;
    $metadata->viewport = $metadataDto->viewport;
    $metadata->robots = $metadataDto->robots;
    $metadata->charset = $metadataDto->charset;
    $metadata->totalTile = $metadataDto->totalTile;
    $metadata->totalDescription = $metadataDto->totalDescription;
    $metadata->httpEquivRefreshPresent = $metadataDto->httpEquivRefreshPresent;
    $metadata->webpageId = $metadataDto->webpageId;

    if ($metadata->id != null) {
      $metadata->updated_at = time();
    }

    $metadata->save();

    return $metadata;
  }
}
