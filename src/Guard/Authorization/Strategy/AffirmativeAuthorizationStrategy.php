<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Strategy;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationStrategy;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Voters;

final class AffirmativeAuthorizationStrategy implements AuthorizationStrategy
{
    private bool $allowIfAllAbstain;
    private Voters $voters;

    public function __construct(Voters $voters, bool $allowIfAllAbstain)
    {
        $this->voters = $voters;
        $this->allowIfAllAbstain = $allowIfAllAbstain;
    }

    public function decide(Tokenable $token, iterable $attributes, object $subject): bool
    {
        $deny = 0;

        foreach ($attributes as $attribute) {
            /** @var Votable $voter */
            foreach ($this->voters->current() as $voter) {
                $decision = $voter->vote($token, [$attribute], $subject);

                switch ($decision) {
                    case Votable::ACCESS_GRANTED:
                        return true;

                    case Votable::ACCESS_DENIED:
                        $deny++;
                }
            }
        }

        return ($deny > 0) ? false : $this->allowIfAllAbstain;
    }
}
