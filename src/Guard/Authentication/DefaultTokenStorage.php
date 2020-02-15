<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authentication;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;

final class DefaultTokenStorage implements TokenStorage
{
    private ?Tokenable $token = null;

    public function getToken(): ?Tokenable
    {
        return $this->token;
    }

    public function store(?Tokenable $token): void
    {
        $this->token = $token;
    }

    public function clear(): void
    {
        $this->token = null;
    }

    public function isEmpty(): bool
    {
        return null === $this->token;
    }

    public function isNotEmpty(): bool
    {
        return $this->token instanceof Tokenable;
    }
}
