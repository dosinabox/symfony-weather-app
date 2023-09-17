<?php

namespace App\Infrastructure\Weather;

use App\Domain\Weather\Exception\CityNotFoundException;
use App\Domain\Weather\Exception\ServiceUnavailableException;
use App\Domain\Weather\Exception\UnauthorizedException;
use App\Entity\Forecast;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommonWeatherProvider
{
    public function __construct(
        protected readonly HttpClientInterface $client,
        protected readonly ContainerBagInterface $parameters,
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @param string $city
     * @param string $apiUrl
     * @param string $apiKey
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws CityNotFoundException
     * @throws ServiceUnavailableException
     * @throws UnauthorizedException
     * @throws \JsonException
     */
    public function getContent(string $city, string $apiUrl, string $apiKey): mixed
    {
        $requestUrl = sprintf($apiUrl, $city, $apiKey);
        $response = $this->client->request('GET', $requestUrl);
        $code = $response->getStatusCode();

        if ($code === 400 || $code === 404) {
            throw new CityNotFoundException($city);
        }

        if ($code === 503) {
            throw new ServiceUnavailableException();
        }

        if ($code === 401) {
            throw new UnauthorizedException();
        }

        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function createForecast(string $city, float $temp): Forecast
    {
        $forecast = new Forecast();
        $forecast->setCity($city);
        $forecast->setProvider((new \ReflectionClass($this))->getShortName());
        $forecast->setTemp($temp);
        $forecast->setTime(new \DateTime());
        $this->entityManager->persist($forecast);
        $this->entityManager->flush();

        return $forecast;
    }
}
