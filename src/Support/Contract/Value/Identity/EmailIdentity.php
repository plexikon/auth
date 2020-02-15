<?php

namespace Plexikon\Auth\Support\Contract\Value\Identity;

use Plexikon\Auth\Support\Contract\Value\Identifier;

interface EmailIdentity extends Identifier
{
    public function getValue(): string;
}
