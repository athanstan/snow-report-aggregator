<?php

namespace App\Livewire;

use App\Models\SnowReport;
use App\Observers\SnowReportCrawlerObserver;
use App\Observers\SnowReportInfoCrawlerObserver;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Spatie\Crawler\Crawler;
use Livewire\Attributes\On;

class MainAggregator extends Component
{
    public $snowReports;
    public SnowReport $selectedSnowReport;
    public bool $open = false;
    public array $favouriteSnowReports = [];

    #[On('refresh')]
    public function mount()
    {
        $cacheKey = 'snowReports' . implode($this->favouriteSnowReports);
        $this->snowReports = Cache::remember($cacheKey, 1800, function () {
            return SnowReport::query()
                ->when($this->favouriteSnowReports, function ($query) {
                    $query->whereIn('id', $this->favouriteSnowReports);
                })
                ->orderBy('open_lifts', 'desc')
                ->get();
        });

        if ($this->snowReports->isEmpty() || $this->snowReports->first()->updated_at->diffInMinutes(now()) > 30) {
            $this->fetchContent();
            Cache::forget($cacheKey);
        }
    }

    private function fetchContent()
    {
        Crawler::create()
            ->setCrawlObserver(new SnowReportCrawlerObserver())
            ->setMaximumDepth(0)
            ->setTotalCrawlLimit(1)
            ->startCrawling('https://snowreport.gr');

        $this->dispatch('refresh')->self();
    }

    public function resetSelectedSnowReport()
    {
        $this->reset('selectedSnowReport');
    }

    public function loadSnowReportInfo(SnowReport $snowReport)
    {
        $this->selectedSnowReport = Cache::remember(
            'snowReport' . $snowReport->id,
            3600,
            function () use ($snowReport) {
                return SnowReport::query()
                    ->where('id', $snowReport->id)
                    ->with([
                        'lifts' => function ($query) {
                            $query->orderBy('status', 'desc');
                        },
                        'slopes' => function ($query) {
                            $query->orderBy('status', 'desc');
                        }
                    ])
                    ->first();
            }
        );

        Crawler::create()
            ->setCrawlObserver(new SnowReportInfoCrawlerObserver($snowReport))
            ->setMaximumDepth(0)
            ->startCrawling($snowReport->link . '/', $snowReport->id);
        if ($this->selectedSnowReport->lifts->isEmpty() || $this->selectedSnowReport->lifts->first()->updated_at->diffInHours(now()) > 1) {

            cache()->forget('snowReport' . $snowReport->id);
        }
        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        return view('livewire.main-aggregator', [
            'snowReports' => $this->snowReports,
        ]);
    }
}
