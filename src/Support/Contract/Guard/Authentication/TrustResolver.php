<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authentication;

interface TrustResolver
{
    public function isFullyAuthenticated(?Tokenable $token): bool;

    public function isRemembered(?Tokenable $token): bool;

    public function isAnonymous(?Tokenable $token): bool;
}
