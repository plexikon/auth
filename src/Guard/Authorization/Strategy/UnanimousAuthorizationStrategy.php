<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization\Strategy;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationStrategy;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Voters;

final class UnanimousAuthorizationStrategy implements AuthorizationStrategy
{
    private Voters $voters;
    private bool $allowIfAllAbstain;

    public function __construct(Voters $voters, bool $allowIfAllAbstain)
    {
        $this->voters = $voters;
        $this->allowIfAllAbstain = $allowIfAllAbstain;
    }

    public function decide(Tokenable $token, iterable $attributes, object $subject): bool
    {
        $grant = 0;

        foreach ($attributes as $attribute) {
            /** @var Votable $voter */
            foreach ($this->voters->current() as $voter) {
                $decision = $voter->vote($token, [$attribute], $subject);

                switch ($decision) {
                    case Votable::ACCESS_GRANTED:
                        ++$grant;
                        break;

                    case Votable::ACCESS_DENIED:
                        return false;

                    default:
                        break;
                }
            }
        }

        return ($grant > 0) ?? $this->allowIfAllAbstain;
    }
}
