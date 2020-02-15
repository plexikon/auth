<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authorization;

use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Voters;

final class ResolverVoters implements Voters
{
    private Container $container;
    private array $voters;

    public function __construct(Container $container, string ...$voters)
    {
        if (!$voters) {
            throw new InvalidArgumentException('You must add at least one voter');
        }

        $this->container = $container;
        $this->voters = $voters;
    }

    public function current(): iterable
    {
        foreach ($this->voters as $voter) {
            yield $this->container->get($voter);
        }
    }
}
