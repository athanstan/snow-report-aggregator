<?php

namespace App\Http\Controllers;

use App\Observers\SnowReportCrawlerObserver;
use Illuminate\Http\Request;
use Spatie\Crawler\Crawler;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        Crawler::create()
            ->setCrawlObserver(new SnowReportCrawlerObserver())
            ->setMaximumDepth(0)
            ->setTotalCrawlLimit(1)
            ->startCrawling('https://snowreport.gr');
    }
}
