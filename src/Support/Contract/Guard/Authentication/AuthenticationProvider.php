<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authentication;

interface AuthenticationProvider extends Authenticatable
{
    public function supportToken(Tokenable $token): bool;
}
