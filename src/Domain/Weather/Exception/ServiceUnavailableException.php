<?php

namespace App\Domain\Weather\Exception;

final class ServiceUnavailableException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Service unavailable.', code: 503);
    }
}
