<?php

namespace App\Livewire;

use App\Http\Integrations\SnowresortWeather\Connectors\SnowResortWeatherConnector;
use App\Http\Integrations\SnowresortWeather\Requests\GetSnowResortWeather;
use App\Models\SnowReport;
use Illuminate\Support\Collection;
use Livewire\Component;

class NextSnowfallList extends Component
{
    public Collection $nextSnowfallList;

    public function mount()
    {
        $this->nextSnowfallList = collect();
        $connector = new SnowResortWeatherConnector();

        SnowReport::select('id', 'name', 'longitude', 'latitude', 'altitude')
            ->get()->each(function ($resort) use ($connector) {
                if (
                    $resort->latitude === null
                    || $resort->longitude === null
                    || $resort->altitude === null
                ) {
                    return true;
                }

                $request = new GetSnowResortWeather($resort->latitude, $resort->longitude, $resort->altitude, 0);

                $response = $connector->send($request);

                $snowfallDate = null;
                $heavySnowfallDate = null;

                $jsonResponse = $response->json();

                foreach ($jsonResponse['description'] as $key => $value) {
                    if ($snowfallDate !== null && $heavySnowfallDate !== null) {
                        break;
                    }

                    if ($snowfallDate === null && preg_match("/<div[^>]*color:green[^>]*>/", $value)) {
                        $snowfallDate = $jsonResponse['date'][$key];
                    }

                    if ($heavySnowfallDate === null && preg_match("/<div[^>]*color:red[^>]*>/", $value)) {
                        $heavySnowfallDate = $jsonResponse['date'][$key];
                    }
                }

                if ($snowfallDate === null && $heavySnowfallDate === null) {
                    return true;
                }

                $this->nextSnowfallList->push([
                    'name' => $resort->name,
                    'snowfall' => $snowfallDate,
                    'heavySnowfall' => $heavySnowfallDate,
                ]);
            });
    }

    public function render()
    {
        return view(
            'livewire.next-snowfall-list',
            ['nextSnowfallList' => $this->nextSnowfallList]
        );
    }
}
