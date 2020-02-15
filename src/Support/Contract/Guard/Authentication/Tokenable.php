<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authentication;

use Plexikon\Auth\Support\Contract\Firewall\Key\ContextKey;
use Plexikon\Auth\Support\Contract\Value\Credential\Credential;
use Serializable;

interface Tokenable extends Serializable
{
    /**
     * @return string[]
     */
    public function getRoleNames(): array;

    public function hasRoles(): bool;

    public function setIdentity($identity): void;

    public function getIdentity();

    public function getCredentials(): Credential;

    public function getFirewallKey(): ContextKey;

    public function isAuthenticated(): bool;

    public function setAuthenticated(bool $isAuthenticated): void;

    public function removeAttribute(string $key): bool;

    public function hasAttribute(string $key): bool;

    public function setAttribute(string $key, $value): void;

    public function getAttribute(string $key);

    public function getAttributes(): array;

    public function setAttributes(array $attributes): void;
}
