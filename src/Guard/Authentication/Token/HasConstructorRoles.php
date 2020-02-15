<?php

namespace Plexikon\Auth\Guard\Authentication\Token;

use Plexikon\Auth\Support\Contract\Domain\Role\Role;
use RuntimeException;

trait HasConstructorRoles
{
    /**
     * @var string[]
     */
    private array $roleNames = [];

    protected function __construct(iterable $roles = [])
    {
        foreach ($roles as $role) {
            if($role instanceof Role){
                $this->roleNames[] = $role->getRole();
            }elseif (is_string($role)){
                $this->roleNames[] = $role;
            }else{
                $message = 'Role must be a string or implements Role contract ' . Role::class;

                throw new RuntimeException($message);
            }
        }
    }

    public function getRoleNames(): array
    {
        return $this->roleNames;
    }

    public function hasRoles(): bool
    {
        return !empty($this->roleNames);
    }
}
