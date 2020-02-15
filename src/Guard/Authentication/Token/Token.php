<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authentication\Token;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

abstract class Token implements Tokenable
{
    use HasConstructorRoles, HasTokenAttributes, HasTokenIdentity, HasTokenSerializer;

    private bool $isAuthenticated = false;

    public function setIdentity($user): void
    {
        $this->identity = $this->setTokenIdentity($user);
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function isAuthenticated(): bool
    {
        return $this->isAuthenticated;
    }

    public function setAuthenticated(bool $isAuthenticated): void
    {
        $this->isAuthenticated = $isAuthenticated;
    }
}
