<?php

namespace App\Observers;

use App\Enums\SnowReportLiftStatus;
use App\Models\Lift;
use App\Models\Slope;
use App\Models\SnowReport;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class SnowReportInfoCrawlerObserver extends CrawlObserver
{
    private $content;
    private SnowReport $snowreport;

    public function __construct(Snowreport $snowreport)
    {
        $this->snowreport = $snowreport;
        $this->content = null;
    }

    /**
     * Called when the crawler will crawl the url.
     */
    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        Log::info('willCrawl', ['url' => $url]);
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {

        $content = (string) $response->getBody();

        $content1 = htmlspecialchars_decode($content, ENT_QUOTES);
        $content1 = mb_convert_encoding($content1, "UTF-8", "ISO-8859-7");
        $content2 = Str::between(
            $content1,
            '<div class="col-xs-12 col-sm-6 col-md-5 col-lg-6 resortInfo">',
            '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 resortCams">'
        );
        $this->content = trim($content2);

        $utf8Content = mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8');

        $crawler = new Crawler();
        $crawler->addHtmlContent($utf8Content);

        $crawler->filter('a')->each(function (Crawler $node, $i) {

            $liftNameClasses = $node->filter('.lift-name')->count()
                ? explode(' ', trim($node->filter('.lift-name')->first()->attr('class')))
                : [];

            $liftNameColorClass = isset($liftNameClasses[1]) ? $liftNameClasses[1] : '';

            $liftName = $node->filter('.lift-name.' . $liftNameColorClass)->count()
                ? trim($node->filter('.lift-name.' . $liftNameColorClass)->text())
                : '';

            $liftCapacity = $node->filter('.lift-capacity')->count()
                ? trim($node->filter('.lift-capacity')->text())
                : '';

            $status = SnowReportLiftStatus::tryFrom($liftNameColorClass);

            if ($status === null) {
                $status = SnowReportLiftStatus::IDLE;
            }

            if (Str::contains($liftName, 'Πίστα')) {
                Slope::updateOrCreate(
                    [
                        'name' => $liftName,
                        'snow_report_id' => $this->snowreport->id,
                    ],
                    [
                        'status' => $status->toStatusString(),
                        'updated_at' => now(),
                    ]
                );

                return; // continue
            }

            Lift::updateOrCreate(
                [
                    'name' => $liftName,
                    'snow_report_id' => $this->snowreport->id,
                ],
                [
                    'status' => $status->toStatusString(),
                    'capacity' => $liftCapacity,
                    'updated_at' => now(),
                ]
            );
        });
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null,
    ): void {
        Log::info("crawlFailed");
    }

    /*
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        //do something someday...
    }
}
