<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Voter;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TrustResolver;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;

final class TokenVoter implements Votable
{
    public const AUTHENTICATED_FULLY = 'is_fully_authenticated_token';
    public const AUTHENTICATED_REMEMBERED = 'is_remembered_token';
    public const AUTHENTICATED_ANONYMOUSLY = 'is_anonymous_token';
    public const ALL = [self::AUTHENTICATED_FULLY, self::AUTHENTICATED_REMEMBERED, self::AUTHENTICATED_ANONYMOUSLY];

    private TrustResolver $trustResolver;

    public function __construct(TrustResolver $trustResolver)
    {
        $this->trustResolver = $trustResolver;
    }

    public function vote(Tokenable $token, iterable $attributes, object $subject): int
    {
        foreach ($attributes as $attribute) {
            if ($this->noMatch($attribute)) {
                continue;
            }

            return $this->isAuthenticated($token) ? self::ACCESS_GRANTED : self::ACCESS_DENIED;
        }

        return self::ACCESS_ABSTAIN;
    }

    protected function isAuthenticated(Tokenable $token): bool
    {
        return $this->trustResolver->isFullyAuthenticated($token)
            || $this->trustResolver->isRemembered($token)
            || $this->trustResolver->isAnonymous($token);
    }

    protected function noMatch(string $attribute = null): bool
    {
        return null === $attribute || !in_array($attribute, self::ALL, true);
    }
}
