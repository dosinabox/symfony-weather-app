<?php

namespace App\Controller;

use App\Entity\Forecast;
use App\Infrastructure\Weather\CommonWeatherProviderTrait;
use App\Infrastructure\Weather\OpenWeather\OpenWeatherProvider;
use App\Infrastructure\Weather\WeatherAPI\WeatherAPIProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    use CommonWeatherProviderTrait;

    public function __construct(
        private readonly OpenWeatherProvider $provider1,
        private readonly WeatherAPIProvider $provider2,
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(path: '/weather', name: 'weather')]
    public function index(Request $request): Response
    {
        $city = $request->getPayload()->get('city');

        if ($city) {
            try {
                $forecasts = [
                    $forecast1 = $this->provider1->getForecast($city),
                    $forecast2 = $this->provider2->getForecast($city),
                ];

                $tempAverage = $this->getAverageTemp(
                    $forecast1->getTemp(),
                    $forecast2->getTemp(),
                );

                $history = $this->entityManager->getRepository(Forecast::class)->findBy(['city' => $city]);
            } catch (\Throwable $exception) {
                $error = $exception->getMessage();
            }
        }

        return $this->render('weather/index.html.twig', [
            'city' => $city ?? null,
            'forecasts' => $forecasts ?? null,
            'tempAverage' => $tempAverage ?? null,
            'history' => $history ?? null,
            'error' => $error ?? null,
        ]);
    }
}
