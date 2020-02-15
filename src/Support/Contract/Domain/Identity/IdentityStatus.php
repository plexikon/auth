<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

interface IdentityStatus
{
    public function isIdentityExpired(): bool;

    public function isIdentityNonLocked(): bool;

    public function isIdentityEnabled(): bool;
}
