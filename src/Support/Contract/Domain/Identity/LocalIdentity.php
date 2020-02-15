<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

interface LocalIdentity extends Identity
{
    public function getPassword(): EncodedCredentials;
}
