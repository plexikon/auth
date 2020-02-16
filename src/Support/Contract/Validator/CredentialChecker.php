<?php

namespace Plexikon\Auth\Support\Contract\Validator;

use Plexikon\Auth\Support\Contract\Domain\Identity\Identity;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

interface CredentialChecker
{
    public function checkCredentials(Identity $identity, Tokenable $token): void;
}
