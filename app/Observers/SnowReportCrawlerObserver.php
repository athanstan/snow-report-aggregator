<?php

namespace App\Observers;

use App\Enums\SnowReportStatus;
use App\Models\SnowReport;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class SnowReportCrawlerObserver extends CrawlObserver
{
    private $content;

    public function __construct()
    {
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
        // Get the response body
        $content = (string) $response->getBody();

        // convert encoding
        $content1 = htmlspecialchars_decode($content, ENT_QUOTES);
        $content1 = mb_convert_encoding($content1, "UTF-8", "ISO-8859-7");
        $content2 = Str::between(
            $content1,
            '<li class="has-sub"><a href="http://www.snowreport.gr">',
            '<li class="has-sub"><a href="http://www.snowreport.gr/trips" target="blank">'
        );
        $content3 = preg_replace('/\s+/', ' ', $content2);
        $content4 = Str::after($content3, 'Χιονοδρομικά </a>');
        $content5 = Str::before($content4, '</li></ul>');

        $this->content = trim($content5);
        $utf8Content = mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8');

        $crawler = new Crawler();

        $crawler->addHtmlContent($utf8Content);

        $linkData = [];

        $crawler->filter('a')->each(function (Crawler $node, $i) use (&$linkData) {
            $href = $node->attr('href');
            $color = $node->filter('font')->count()
                ? $node->filter('font')->attr('color')
                : 'default';
            $text = trim($node->text());

            if (preg_match('/(\d+)\/(\d+)$/', $text, $matches)) {
                $open_lifts = $matches[1];  // Open lifts
                $total_lifts = $matches[2]; // Total lifts
            }

            // Remove the lift information from the text
            $text = trim(preg_replace('/\d+\/\d+$/', '', $text));
            // Remove the parenthesis information
            $name = trim(preg_replace('/\s*\(\d+\)$/', '', $text));

            $status = SnowReportStatus::tryFrom($color);

            if ($status === null) {
                $status = SnowReportStatus::MAINTENANCE;
            }

            SnowReport::updateOrCreate(
                ['name' => $name],
                [
                    'link' => $href,
                    'status' => $status->toStatusString(),
                    'open_lifts' => $open_lifts ?? null,
                    'total_lifts' => $total_lifts ?? null,
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
