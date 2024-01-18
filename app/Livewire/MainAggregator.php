<?php

namespace App\Livewire;

use App\Models\SnowReport;
use App\Observers\SnowReportCrawlerObserver;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Spatie\Crawler\Crawler;
use Livewire\Attributes\On;


class MainAggregator extends Component
{
    public $snowReports;

    #[On('refresh')]
    public function mount()
    {
        $this->snowReports = Cache::remember('snowReports', 3600, function () {
            return SnowReport::get();
        });

        if ($this->snowReports->isEmpty() || $this->snowReports->first()->updated_at->diffInHours(now()) > 1) {
            $this->fetchContent();
        }
    }

    private function fetchContent()
    {
        Crawler::create()
            ->setCrawlObserver(new SnowReportCrawlerObserver())
            ->setMaximumDepth(0)
            ->startCrawling('https://snowreport.gr');

        $this->dispatch('refresh')->self();
    }

    public function render()
    {
        return view('livewire.main-aggregator', [
            'snowReports' => $this->snowReports,
        ]);
    }
}
