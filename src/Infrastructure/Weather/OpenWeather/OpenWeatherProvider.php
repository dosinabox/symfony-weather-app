<?php

namespace App\Infrastructure\Weather\OpenWeather;

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

final class OpenWeatherProvider implements WeatherProviderInterface
{
    use CommonWeatherProviderTrait;

    public function getProviderName(): string
    {
        return 'OpenWeatherMap.org';
    }

    public function getApiUrl(): string
    {
        return $_ENV['OPENWEATHER_API_URL'];
    }

    public function getApiKey(): string
    {
        return $_ENV['OPENWEATHER_API_KEY'];
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

        return $this->createForecast($city, $content['main']['temp'], $this->getProviderName());
    }
}
