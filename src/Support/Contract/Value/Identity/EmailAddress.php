<?php

namespace Plexikon\Auth\Support\Contract\Value\Identity;

use Plexikon\Auth\Support\Contract\Value\Value;

interface EmailAddress extends Value
{
    public function getValue(): string;
}
