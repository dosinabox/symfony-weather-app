<?php

namespace App\Infrastructure\Weather\WeatherAPI;

use App\Domain\Weather\Exception\ServiceUnavailableException;
use App\Domain\Weather\Exception\UnauthorizedException;
use App\Domain\Weather\WeatherProviderInterface;
use App\Entity\Forecast;
use App\Infrastructure\Weather\CommonWeatherProviderTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class WeatherAPIProvider implements WeatherProviderInterface
{
    use CommonWeatherProviderTrait;

    public function getProviderName(): string
    {
        return 'WeatherAPI.com';
    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getApiUrl(): string
    {
        return $this->parameters->get('weather.api.url.weatherapi');
    }

    /**
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \JsonException
     */
    public function getForecast(string $city): Forecast
    {
        $content = $this->getContent($city, $this->getApiUrl(), $this->getApiKey());

        return $this->createForecast($city, $content['current']['temp_c'], $this->getProviderName());
    }
}
