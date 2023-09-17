<?php

namespace App\Controller;

use App\Infrastructure\Weather\OpenWeather\OpenWeatherProvider;
use App\Infrastructure\Weather\WeatherAPI\WeatherAPIProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    public function __construct(
        private readonly OpenWeatherProvider $provider1,
        private readonly WeatherAPIProvider $provider2,
    ) {
    }

    #[Route(path: '/weather', name: 'weather')]
    public function index(Request $request): Response
    {
        $city = $request->getPayload()->get('city');

        if ($city) {
            try {
                $forecast1 = $this->provider1->getForecast($city);
                $forecast2 = $this->provider2->getForecast($city);

                $forecast = ($forecast1 + $forecast2) / 2;
            } catch (\Throwable $exception) {
                $error = $exception->getMessage();
            }
        }

        return $this->render('weather/index.html.twig', [
            'forecast' => $forecast ?? null,
            'error' => $error ?? null,
        ]);
    }
}
