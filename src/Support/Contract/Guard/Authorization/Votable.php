<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authorization;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

interface Votable
{
    public const ACCESS_GRANTED = 1;

    public const ACCESS_ABSTAIN = 0;

    public const ACCESS_DENIED = -1;

    public function vote(Tokenable $token, iterable $attributes, object $subject): int;
}
