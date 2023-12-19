<?php

namespace App\WebPage\Services;

use App\WebPage\Repositories\WebpageRepository;
use Illuminate\Contracts\Pagination\Paginator;

class WebpageService
{
    private WebpageRepository $webpageRepository;

    public function __construct(
        WebpageRepository $webpageRepository,
    ) {
        $this->webpageRepository = $webpageRepository;
    }

    public function getAllWebpages() : Paginator
    {
        return $this->webpageRepository->findWithPagination();
    }

    public function getPreviewImage(int $id) : string|null
    {
        return $this->webpageRepository->getPreviewImage($id);
    }
}
