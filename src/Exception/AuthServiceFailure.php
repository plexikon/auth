<?php
declare(strict_types=1);

namespace Plexikon\Auth\Exception;

use Plexikon\Auth\Support\Contract\Domain\Identity\Identity;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

class AuthServiceFailure extends AuthenticationException
{
    public static function noAuthenticationProvider(): self
    {
        return new self('No authentication provider has been provided for Authentication manager');
    }

    public static function unsupportedIdentityProvider(Identity $identity): self
    {
        $identityClass = get_class($identity);

        return new self("No identity provider support identity class {$identityClass}");
    }

    public static function unsupportedToken(Tokenable $token): self
    {
        $tokenClass = get_class($token);

        return new self("No authentication provider support token {$tokenClass}");
    }

    public static function credentialsNotFound(): self
    {
        return new self('No token found in storage');
    }
}
