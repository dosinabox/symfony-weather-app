<?php

namespace App\Domain\Weather\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CityNotFoundException extends NotFoundHttpException
{
    public function __construct($city)
    {
        parent::__construct(message: 'City ' . $city . ' not found.');
    }
}
