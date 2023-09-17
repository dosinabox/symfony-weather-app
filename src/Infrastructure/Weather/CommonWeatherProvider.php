<?php

namespace App\Infrastructure\Weather;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommonWeatherProvider
{
    public function __construct(
        protected HttpClientInterface $client,
        protected ContainerBagInterface $parameters
    ) {
    }

    public function getContent(string $city, string $apiUrl, string $apiKey)
    {
        //TODO add custom exceptions
        $requestUrl = sprintf($apiUrl, $city, $apiKey);
        $response = $this->client->request('GET', $requestUrl);
        $code = $response->getStatusCode();

        if ($code === 400 || $code === 404) {
            throw new NotFoundHttpException('City ' . $city . ' not found.');
        }

        if ($code === 503) {
            throw new \Exception('Service unavailable.');
        }

        if ($code === 401) {
            throw new \Exception('Unauthorized.');
        }

        return json_decode($response->getContent(), true);
    }
}
