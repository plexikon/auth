<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Strategy;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationStrategy;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Voters;

final class ConsensusAuthorizationStrategy implements AuthorizationStrategy
{
    private Voters $voters;
    private bool $allowIfAllAbstain;
    private bool $allowIfEqual;

    public function __construct(Voters $voters, bool $allowIfAllAbstain, bool $allowIfEqual)
    {
        $this->voters = $voters;
        $this->allowIfAllAbstain = $allowIfAllAbstain;
        $this->allowIfEqual = $allowIfEqual;
    }

    public function decide(Tokenable $token, iterable $attributes, object $subject): bool
    {
        $grant = 0;
        $deny = 0;

        foreach ($attributes as $attribute) {
            /** @var Votable $voter */
            foreach ($this->voters->current() as $voter) {
                $decision = $voter->vote($token, [$attribute], $subject);

                switch ($decision) {
                    case Votable::ACCESS_GRANTED:
                        ++$grant;
                        break;

                    case Votable::ACCESS_DENIED:
                        ++$deny;
                        break;
                }
            }
        }

        if ($grant > $deny) {
            return true;
        }

        if ($deny > $grant) {
            return false;
        }

        return ($grant > 0) ? $this->allowIfEqual : $this->allowIfAllAbstain;
    }
}
