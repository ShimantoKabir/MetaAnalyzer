<?php

namespace App\WebPage\Providers;

interface PreviewProvider
{
  function providePreviewImage(string $url): string;
}
