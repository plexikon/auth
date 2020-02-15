<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization;

use Illuminate\Contracts\Container\Container;
use Plexikon\Auth\Support\Contract\Domain\Identity\Identity;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationChecker;

final class AuthorizationResolver
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function isGranted(iterable $attributes, ?object $subject): bool
    {
        return $this->authorizationChecker()->isGranted($attributes, $subject);
    }

    public function isNotGranted(iterable $attributes, ?object $subject): bool
    {
        return !$this->authorizationChecker()->isGranted($attributes, $subject);
    }

    public function getIdentity(): ?Identity
    {
        $token = $this->getStorage()->getToken();

        if (!$token) {
            return null;
        }

        $identity = $token->getIdentity();

        if ($identity instanceof Identity) {
            return $identity;
        }

        return null;
    }

    public function getToken(): ?Tokenable
    {
        return $this->getStorage()->getToken();
    }

    public function getStorage(): TokenStorage
    {
        return $this->container->get(TokenStorage::class);
    }

    private function authorizationChecker(): AuthorizationChecker
    {
        return $this->container->get(AuthorizationChecker::class);
    }
}
