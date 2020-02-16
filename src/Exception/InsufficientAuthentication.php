<?php
declare(strict_types=1);

namespace Plexikon\Auth\Exception;

class InsufficientAuthentication extends AuthenticationException
{
    public static function fromAuthorization(AuthorizationException $exception): self
    {
        $message = 'Full authentication is required to access this resource';

        return new self($message, 0, $exception);
    }
}
