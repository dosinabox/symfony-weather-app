<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route(path: '/weather', name: 'weather')]
    public function index(Request $request): Response
    {
        $country = $request->getPayload()->get('country');
        $city = $request->getPayload()->get('city');
        $forecast = 'test';
        $error = null;

        return $this->render('weather/index.html.twig', [
            'forecast' => $forecast,
            'error' => $error,
        ]);
    }
}
