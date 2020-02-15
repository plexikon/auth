<?php
declare(strict_types=1);

namespace Plexikon\Auth\Exception;

use Plexikon\Auth\Support\Contract\Exception\AuthException;
use RuntimeException;

class AuthenticationException extends RuntimeException implements AuthException
{
    //
}
