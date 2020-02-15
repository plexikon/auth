<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Voter;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\RoleHierarchy;

final class RoleHierarchyVoter extends RoleVoter
{
    private RoleHierarchy $roleHierarchy;

    public function __construct(RoleHierarchy $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    protected function extractRoles(Tokenable $token): array
    {
        return $this->roleHierarchy->getReachableRoles(...$token->getRoleNames());
    }
}
