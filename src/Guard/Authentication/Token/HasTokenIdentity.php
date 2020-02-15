<?php

namespace Plexikon\Auth\Guard\Authentication\Token;

use Plexikon\Auth\Support\Contract\Domain\Identity\Identity;
use Plexikon\Auth\Support\Contract\Value\Identifier;
use InvalidArgumentException;

trait HasTokenIdentity
{
    /**
     * @var Identity|Identifier
     */
    private $identity;

    /**
     * @param Identity|Identifier $identity
     * @return Identity|Identifier
     */
    private function setTokenIdentity($identity)
    {
        if (!$identity instanceof Identity && !$identity instanceof Identifier) {
            $message = 'User must implement ';
            $message .= Identity::class . ' or ';
            $message .= Identifier::class;

            throw new InvalidArgumentException($message);
        }

        return $identity;
    }

    private function identityHasChanged($identity): void
    {
        // todo
    }
}
