<?php

namespace App\Infrastructure\Weather;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
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
        $requestUrl = sprintf($apiUrl, $city, $apiKey);
        $response = $this->client->request('GET', $requestUrl);

        return json_decode($response->getContent(), true);
    }
}
