<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

use Plexikon\Auth\Support\Contract\Value\Credential\EncodedCredential;

interface LocalIdentity extends Identity
{
    public function getPassword(): EncodedCredential;
}
