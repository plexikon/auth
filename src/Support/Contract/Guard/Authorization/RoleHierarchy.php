<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authorization;

interface RoleHierarchy
{
    public function getReachableRoles(string ...$roles): array;
}
