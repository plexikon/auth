<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authorization;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

interface AuthorizationStrategy
{
    public const AFFIRMATIVE = 'affirmative';

    public const CONSENSUS = 'consensus';

    public const UNANIMOUS = 'unanimous';

    public function decide(Tokenable $token, iterable $attributes, object $subject): bool;
}
