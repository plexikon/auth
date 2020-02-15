<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthenticationException;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Authenticatable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Guardable;
use Plexikon\Auth\Support\Contract\Http\Response\Entrypoint;
use Symfony\Component\HttpFoundation\Response;

final class Guard implements Guardable
{
    private TokenStorage $storage;
    private Authenticatable $authenticationManager;
    private Entrypoint $entrypoint;
    private Dispatcher $eventDispatcher;

    public function __construct(TokenStorage $storage,
                                Authenticatable $authenticationManager,
                                Entrypoint $entrypoint,
                                Dispatcher $eventDispatcher)
    {
        $this->storage = $storage;
        $this->authenticationManager = $authenticationManager;
        $this->entrypoint = $entrypoint;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function authenticateToken(Tokenable $token): Tokenable
    {
        return $this->authenticationManager->authenticate($token);
    }

    public function storeToken(?Tokenable $token): void
    {
        $this->storage->store($token);
    }

    public function storeAuthenticatedToken(Tokenable $token): Tokenable
    {
        $this->storage->store(
            $authenticatedToken = $this->authenticateToken($token)
        );

        return $authenticatedToken;
    }

    public function startAuthentication(Request $request, AuthenticationException $exception = null): Response
    {
        return $this->entrypoint->startAuthentication($request, $exception);
    }

    public function clearStorage(): void
    {
        $this->storage->clear();
    }

    public function fireAuthenticationEvent($authenticationEvent, array $payload = [], bool $halt = false): ?array
    {
        return $this->eventDispatcher->dispatch($authenticationEvent, $payload, $halt);
    }

    public function isStorageEmpty(): bool
    {
        return $this->storage->isEmpty();
    }

    public function isStorageFilled(): bool
    {
        return $this->storage->isNotEmpty();
    }

    public function getToken(): ?Tokenable
    {
        return $this->storage->getToken();
    }
}
