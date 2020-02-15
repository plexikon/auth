<?php

namespace Plexikon\Auth\Support\Contract\Guard;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthenticationException;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Symfony\Component\HttpFoundation\Response;

interface Guardable
{
    public function authenticateToken(Tokenable $token): Tokenable;

    public function storeAuthenticatedToken(Tokenable $token): Tokenable;

    public function startAuthentication(Request $request, AuthenticationException $exception = null): Response;

    public function fireAuthenticationEvent($authenticationEvent, array $payload = [], bool $halt = false): ?array;

    public function isStorageEmpty(): bool;

    public function isStorageFilled(): bool;

    public function clearStorage(): void;

    public function getToken(): ?Tokenable;

    public function storeToken(?Tokenable $token): void;
}
