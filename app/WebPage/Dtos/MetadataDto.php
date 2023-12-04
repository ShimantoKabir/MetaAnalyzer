<?php

namespace App\WebPage\Dtos;

class MetadataDto
{
  public int $id;
  public string|null $title = null;
  public string|null $description = null;
  public string|null $viewport = null;
  public string|null $robots = null;
  public string|null $charset = null;
  public int|null $totalTile = null;
  public int|null $totalDescription = null;
  public bool|null $httpEquivRefreshPresent = null;
  public int $webpageId;
}
