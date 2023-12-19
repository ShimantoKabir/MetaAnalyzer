<?php

namespace App\WebPage\Repositories;

use App\WebPage\Models\Webpage;
use App\WebPage\Dtos\WebpageDto;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;


interface WebpageRepository
{
  function saveWebpage(WebpageDto $webpageDto): Webpage;
  function editWebpage(WebpageDto $webpageDto, Webpage $webpage): Webpage;
  function findWebpageByURL(string $url): Webpage|null;
  function findAll(): Collection;
  function findWithPagination() : Paginator;
  function getPreviewImage(int $id) : string|null;
}
