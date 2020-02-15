<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authentication;

interface Authenticatable
{
    public function authenticate(Tokenable $token): Tokenable;
}
