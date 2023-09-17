<?php

namespace App\Infrastructure\Weather\WeatherAPI;

use App\Domain\Weather\Exception\ServiceUnavailableException;
use App\Domain\Weather\Exception\UnauthorizedException;
use App\Domain\Weather\WeatherProviderInterface;
use App\Infrastructure\Weather\CommonWeatherProvider;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

        return $content['current']['temp_c'];
    }
}
