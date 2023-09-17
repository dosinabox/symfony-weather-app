<?php

namespace App\Infrastructure\Weather\WeatherAPI;

use App\Domain\Weather\WeatherProviderInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

final class WeatherAPIProvider implements WeatherProviderInterface
{
    public function getApiUrl(): string
    {
        return env('WEATHERAPI_API_URL');
    }

    public function getApiKey(): string
    {
        return env('WEATHERAPI_API_KEY');
    }

    public function getForecast(string $city)
    {
        $requestUrl = sprintf($this->getApiUrl(), $city, $this->getApiKey());
    }
}
