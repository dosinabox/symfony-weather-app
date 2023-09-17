<?php

namespace App\Infrastructure\Weather\OpenWeather;

use App\Domain\Weather\WeatherProviderInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

final class OpenWeatherProvider implements WeatherProviderInterface
{
    public function getApiUrl(): string
    {
        return env('OPENWEATHER_API_URL');
    }

    public function getApiKey(): string
    {
        return env('OPENWEATHER_API_KEY');
    }

    public function getForecast(string $city)
    {
        $requestUrl = sprintf($this->getApiUrl(), $city, $this->getApiKey());
    }
}
