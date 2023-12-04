<?php

namespace App\Providers;

use App\WebPage\Providers\Implementations\MicroweberPreviewProvider;
use Illuminate\Support\ServiceProvider;
use App\WebPage\Providers\MetadataProvider;
use App\WebPage\Providers\Implementations\PHPHtmlParserProvider;
use App\WebPage\Providers\PreviewProvider;
use App\WebPage\Repositories\Implementations\IMetadataRepository;
use App\WebPage\Repositories\Implementations\IWebpageRepository;
use App\WebPage\Repositories\MetadataRepository;
use App\WebPage\Repositories\WebpageRepository;
use App\WebPage\Types\HtmlParserType;
use App\WebPage\Types\PreviewProviderType;
use Illuminate\Support\Facades\Config;

class MetaDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MetadataProvider::class, function () {
            $htmlParserType = Config::get("env.htmlParserType");
            if ($htmlParserType == HtmlParserType::PHP_HTML_PARSER->value) {
                return new PHPHtmlParserProvider();
            }
        });

        $this->app->bind(PreviewProvider::class, function () {
            $previewProviderType = Config::get("env.previewProviderType");
            if ($previewProviderType == PreviewProviderType::MICROWEBER->value) {
                return new MicroweberPreviewProvider();
            }
        });

        $this->app->bind(WebpageRepository::class, IWebpageRepository::class);
        $this->app->bind(MetadataRepository::class, IMetadataRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
