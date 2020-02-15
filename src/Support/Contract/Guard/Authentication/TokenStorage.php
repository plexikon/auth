<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authentication;

interface TokenStorage
{
    public function getToken(): ?Tokenable;

    public function store(?Tokenable $token): void;

    public function clear(): void;

    public function isEmpty(): bool;

    public function isNotEmpty(): bool;
}
