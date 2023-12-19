<?php

namespace App\WebPage\Repositories\Implementations;

use App\WebPage\Models\Webpage;
use App\WebPage\Dtos\WebpageDto;
use Illuminate\Database\Eloquent\Collection;
use App\WebPage\Repositories\WebpageRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class IWebpageRepository implements WebpageRepository
{
  function saveWebpage(WebpageDto $webpageDto): Webpage
  {
    return $this->saveOrUpdate($webpageDto,  new Webpage());
  }

  function findWebpageByURL(string $url): Webpage|null
  {
    return Webpage::where('url', $url)->first();
  }

  function editWebpage(WebpageDto $webpageDto, Webpage $webpage): Webpage
  {
    return $this->saveOrUpdate($webpageDto,  $webpage);
  }

  function saveOrUpdate(WebpageDto $webpageDto, Webpage $webpage): Webpage
  {
    $webpage->url = $webpageDto->url;
    $webpage->previewImage = $webpageDto->previewImage;

    if ($webpage->id != null) {
      $webpage->updated_at = time();
    }

    $webpage->save();
    return $webpage;
  }

  function findAll(): Collection
  {
    return Webpage::all();
  }

    function findWithPagination() : Paginator
    {
        return Webpage::select(
            DB::raw(
                'id,
                url,
                IF(ISNULL(previewImage), "N/A", "AVAILABLE") AS previewImage,
                created_at,
                updated_at'
            )
        )
        ->with("metadata")
        ->simplePaginate(5);
    }

    function getPreviewImage(int $id): string|null
    {
        $webpage = Webpage::find($id);

        if ($webpage == null){
            return null;
        }else {
            return  $webpage->previewImage;
        }
    }
}
