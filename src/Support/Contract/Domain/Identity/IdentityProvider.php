<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

use Plexikon\Auth\Support\Contract\Value\Identity;

interface IdentityProvider
{
    public function identityOf(Identifier $identifier): Identity;

    public function supports(Identity $identity): bool;
}
