<?php

namespace App\Domain\Weather;

interface WeatherProviderInterface
{
    public function getProviderName(): string;

    public function getApiUrl(): string;

    public function getApiKey(): string;

    public function getForecast(string $city);
}
