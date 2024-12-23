<?php

namespace App\Livewire;

use App\Enums\SnowReportLiftStatusString;
use App\Models\Slope;
use App\Models\SnowReport;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SnowResortData extends Component
{
    #[Computed]
    public function SnowResortData()
    {
        return SnowReport::selectRaw("count(*) as total_snow_resorts")
            ->selectRaw('SUM(open_lifts) as total_open_lifts')
            ->addSelect([
                'total_open_slopes' => Slope::selectRaw('count(CASE WHEN status = ? THEN 1 END)', [SnowReportLiftStatusString::OPEN])
                    ->take(1)
            ])
            ->first();
    }
}
