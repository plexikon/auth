<?php

namespace Plexikon\Auth\Support\Contract\Http\Middleware;

use Plexikon\Auth\Support\Contract\Guard\Guardable;

interface AuthenticationGuard extends Authentication
{
    public function setGuard(Guardable $guard): void;
}
