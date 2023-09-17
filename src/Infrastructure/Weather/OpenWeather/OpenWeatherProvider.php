<?php

namespace App\Infrastructure\Weather\OpenWeather;

use App\Domain\Weather\Exception\ServiceUnavailableException;
use App\Domain\Weather\Exception\UnauthorizedException;
use App\Domain\Weather\WeatherProviderInterface;
use App\Infrastructure\Weather\CommonWeatherProvider;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class OpenWeatherProvider extends CommonWeatherProvider implements WeatherProviderInterface
{
    public function getApiUrl(): string
    {
        return $this->parameters->get('weather.api.url.openweather');
    }

    public function getApiKey(): string
    {
        return $this->parameters->get('weather.api.key.openweather');
    }

    /**
     * @param string $city
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServiceUnavailableException
     * @throws UnauthorizedException
     * @throws \JsonException
     */
    public function getForecast(string $city)
    {
        $content = $this->getContent($city, $this->getApiUrl(), $this->getApiKey());

        return $content['main']['temp'];
    }
}
