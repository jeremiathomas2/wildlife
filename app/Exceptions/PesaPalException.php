<?php

namespace App\Exceptions;

use RuntimeException;

class PesaPalException extends RuntimeException
{
    public static function missingCredentials(): self
    {
        return new self('PesaPal credentials are not configured. Add your consumer key and secret in the Payment settings.');
    }
}