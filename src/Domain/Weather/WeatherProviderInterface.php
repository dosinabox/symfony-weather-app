<?php

namespace App\Domain\Weather;

interface WeatherProviderInterface
{
    public function getApiUrl(): string;

    public function getApiKey(): string;

    public function getForecast(string $city);
}
