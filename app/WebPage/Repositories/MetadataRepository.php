<?php

namespace App\WebPage\Repositories;

use App\WebPage\Models\Metadata;
use App\WebPage\Dtos\MetadataDto;

interface MetadataRepository
{
  function save(MetadataDto $metadataDto): Metadata;
  function edit(MetadataDto $metadataDto, Metadata $metadata): Metadata;
}
