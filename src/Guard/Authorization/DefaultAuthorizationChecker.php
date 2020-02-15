<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthServiceFailure;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Authenticatable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationChecker;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationStrategy;

final class DefaultAuthorizationChecker implements AuthorizationChecker
{
    private Authenticatable $authenticationManager;
    private AuthorizationStrategy $authorizationStrategy;
    private TokenStorage $storage;
    private bool $alwaysAuthenticate;
    private ?Request $request = null;

    public function __construct(Authenticatable $authenticationManager,
                                AuthorizationStrategy $authorizationStrategy,
                                TokenStorage $storage,
                                bool $alwaysAuthenticate)
    {
        $this->authenticationManager = $authenticationManager;
        $this->authorizationStrategy = $authorizationStrategy;
        $this->storage = $storage;
        $this->alwaysAuthenticate = $alwaysAuthenticate;
    }

    public function isGranted(iterable $attributes, ?object $subject): bool
    {
        if (!$token = $this->storage->getToken()) {
            throw AuthServiceFailure::credentialsNotFound();
        }

        return $this->authorizationStrategy->decide(
            $this->authenticateTokenIfNeeded($token),
            $attributes,
            $subject ?? $this->request
        );
    }

    public function isNotGranted(iterable $attributes, ?object $subject): bool
    {
        return !$this->isGranted($attributes, $subject);
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    private function authenticateTokenIfNeeded(Tokenable $token): Tokenable
    {
        if ($this->alwaysAuthenticate || !$token->isAuthenticated()) {
            $token = $this->authenticationManager->authenticate($token);

            $this->storage->store($token);
        }

        return $token;
    }
}
