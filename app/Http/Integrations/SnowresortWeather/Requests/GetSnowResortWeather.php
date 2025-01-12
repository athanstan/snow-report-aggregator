<?php

namespace App\Http\Integrations\SnowresortWeather\Requests;

use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\Request;

final class GetSnowResortWeather extends Request implements Cacheable
{
    use HasCaching;

    protected Method $method = Method::GET;

    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
        private readonly int $altitude,
        private readonly string $duration,

    ) {}

    public function resolveEndpoint(): string
    {
        return '/el/snow/snow_data.php';
    }

    protected function defaultQuery(): array
    {
        return [
            'latlon' => "{$this->latitude},{$this->longitude}",
            'alt' => $this->altitude,
            'dur' => $this->duration,
        ];
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br, zstd',
            'Accept-Language' => 'en-GB,en-US;q=0.9,en;q=0.8,el;q=0.7,fr;q=0.6',
            'X-Requested-With' => 'XMLHttpRequest',
            'sec-ch-ua' => '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store(config('cache.default')));
    }

    public function cacheExpiryInSeconds(): int
    {
        return 60 * 60 * 24;
    }

    public function cacheKey(): string
    {
        return 'snow_resort_weather_' . $this->latitude . '_' . $this->longitude . '_' . $this->altitude;
    }
}
