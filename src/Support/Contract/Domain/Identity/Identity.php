<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

use Plexikon\Auth\Support\Contract\Value\Identifier;

interface Identity
{
    public function getIdentifier(): Identifier;

    public function getRoles(): array;
}
