<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Voter;

use Illuminate\Support\Str;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;

class RoleVoter implements Votable
{
    public const ROLE_PREFIX = 'ROLE_';

    public function vote(Tokenable $token, iterable $attributes, object $subject): int
    {
        $vote = self::ACCESS_ABSTAIN;

        $roles = $this->extractRoles($token);

        foreach ($attributes as $attribute) {
            if (!Str::startsWith($attribute, self::ROLE_PREFIX)) {
                continue;
            }

            $vote = self::ACCESS_DENIED;

            foreach ($roles as $role) {
                if ($attribute === $role) {
                    return self::ACCESS_GRANTED;
                }
            }
        }

        return $vote;
    }

    protected function extractRoles(Tokenable $token): array
    {
        return $token->getRoleNames();
    }
}
