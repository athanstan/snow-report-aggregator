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

    #[On('refresh')]
    public function mount()
    {
        $this->snowReports = Cache::remember('snowReports', 1800, function () {
            return SnowReport::query()
                ->orderBy('open_lifts', 'desc')
                ->get();
        });

        if ($this->snowReports->isEmpty() || $this->snowReports->first()->updated_at->diffInMinutes(now()) > 30) {
            $this->fetchContent();
            Cache::forget('snowReports');
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

        if ($this->selectedSnowReport->lifts->isEmpty() || $this->selectedSnowReport->lifts->first()->updated_at->diffInHours(now()) > 1) {
            Crawler::create()
                ->setCrawlObserver(new SnowReportInfoCrawlerObserver($snowReport))
                ->setMaximumDepth(0)
                ->startCrawling($snowReport->link . '/', $snowReport->id);

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
