<?php

namespace Plexikon\Auth\Support\Contract\Domain\Identity;

interface IdentityChecker
{
    public function onPreAuthentication(Identity $identity): void;

    public function onPostAuthentication(Identity $identity): void;
}
