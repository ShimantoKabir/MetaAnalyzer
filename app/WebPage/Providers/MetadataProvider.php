<?php

namespace App\WebPage\Providers;

use App\WebPage\Dtos\MetadataDto;

interface MetadataProvider
{
  function provideByURL(string $url): MetadataDto;
}
