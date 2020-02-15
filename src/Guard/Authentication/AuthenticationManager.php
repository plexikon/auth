<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authentication;

use Plexikon\Auth\Exception\AuthServiceFailure;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Authenticatable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\AuthenticationProvider;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

final class AuthenticationManager implements Authenticatable
{
    /**
     * @var AuthenticationProvider[]
     */
    private array $authenticationProviders;

    public function __construct(AuthenticationProvider ...$authenticationProviders)
    {
        if (!$authenticationProviders) {
            throw AuthServiceFailure::noAuthenticationProvider();
        }

        $this->authenticationProviders = $authenticationProviders;
    }

    public function authenticate(Tokenable $token): Tokenable
    {
        foreach ($this->authenticationProviders as $authenticationProvider) {
            if (!$authenticationProvider->supportToken($token)) {
                continue;
            }

            return $authenticationProvider->authenticate($token);
        }

        throw AuthServiceFailure::unsupportedToken($token);
    }
}
