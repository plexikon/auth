<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authorization;

use Plexikon\Auth\Guard\Authorization\SymfonyRoleHierarchy;
use Plexikon\Auth\Test\Unit\TestCase;

class SymfonyRoleHierarchyTest extends TestCase
{
    /**
     * @test
     */
    public function it_reach_roles(): void
    {
        $roles = ['ROLE_FOO' => ['ROLE_FOO_BAR'], 'ROLE_BAR' => []];

        $hierarchy = new SymfonyRoleHierarchy($roles);

        $this->assertEquals([
            'ROLE_FOO', 'ROLE_FOO_BAR'
        ], $hierarchy->getReachableRoles('ROLE_FOO'));

        $this->assertEquals(['ROLE_BAR'], $hierarchy->getReachableRoles('ROLE_BAR'));
    }
}
