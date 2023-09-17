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
                $temp1 = $this->provider1->getForecast($city);
                $temp2 = $this->provider2->getForecast($city);

                $tempAverage = ($temp1 + $temp2) / 2;
            } catch (\Throwable $exception) {
                $error = $exception->getMessage();
            }
        }

        return $this->render('weather/index.html.twig', [
            'city' => $city ?? null,
            'temp1' => $temp1 ?? null,
            'temp2' => $temp2 ?? null,
            'tempAverage' => $tempAverage ?? null,
            'error' => $error ?? null,
        ]);
    }
}
