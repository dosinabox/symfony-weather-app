<?php

namespace App\Domain\Weather\Exception;

final class UnauthorizedException extends \Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Unauthorized.', code: 401);
    }
}
