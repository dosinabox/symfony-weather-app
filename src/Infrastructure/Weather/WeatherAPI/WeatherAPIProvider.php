<?php

namespace App\Infrastructure\Weather\WeatherAPI;

use App\Domain\Weather\WeatherProviderInterface;
use App\Infrastructure\Weather\CommonWeatherProvider;

final class WeatherAPIProvider extends CommonWeatherProvider implements WeatherProviderInterface
{
    public function getApiUrl(): string
    {
        return $this->parameters->get('weather.api.url.weatherapi');
    }

    public function getApiKey(): string
    {
        return $this->parameters->get('weather.api.key.weatherapi');
    }

    public function getForecast(string $city)
    {
        $content = $this->getContent($city, $this->getApiUrl(), $this->getApiKey());

        return $content['current']['temp_c'];
    }
}
