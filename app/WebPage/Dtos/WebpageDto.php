<?php

namespace App\WebPage\Dtos;

/**
 * Meta data dto.
 *
 * @author  Shahariar Kabir <kabir3483@gmail.com>
 *
 * @OA\Schema(
 *  title="Web Page Request dto",
 *  description="Web Page Request dto",
 * )
 */
class WebpageDto
{

  public int $id;

  /**
   * @OA\Property(
   *  description="A URL need to capture all meta data and analyze or create preview image.",
   *  title="URL"
   * )
   *
   * @var string
   */
  public string $url;

  public string|null $previewImage = null;

  public MetadataDto $metadataDto;
}
