<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\WebPage\Services\MetaAnalyzerService;

class UpdateMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update all metadata hourly.';


    private MetaAnalyzerService $metaAnalyzerService;

    public function __construct(MetaAnalyzerService $metaAnalyzerService)
    {
        parent::__construct();
        $this->metaAnalyzerService = $metaAnalyzerService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->metaAnalyzerService->updateAllMetadata();
        Log::info("All metadata updated!");
    }
}
