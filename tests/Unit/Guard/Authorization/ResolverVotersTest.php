<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authorization;

use Illuminate\Contracts\Container\Container;
use Plexikon\Auth\Guard\Authorization\ResolverVoters;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;
use Plexikon\Auth\Test\Unit\TestCase;

class ResolverVotersTest extends TestCase
{
    /**
     * @test
     */
    public function it_iterate_over_voters(): void
    {
        $c = $this->prophesize(Container::class);

        $oneVoter = $this->prophesize(Votable::class)->reveal();
        $secondVoter = $this->prophesize(Votable::class)->reveal();

        $c->get('foo')->willReturn($oneVoter);
        $c->get('bar')->willReturn($secondVoter);

        $voters = new ResolverVoters($c->reveal(), 'foo', 'bar');

        $count = 0;
        foreach ($voters->current() as $voter) {
            $this->assertInstanceOf(Votable::class, $voter);

            ++$count;
        }

        $this->assertEquals(2, $count);
    }

    /**
     * @test
     */
    public function it_raise_exception_if_no_voter_provided(): void
    {
        $c = $this->prophesize(Container::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You must add at least one voter');

        new ResolverVoters($c->reveal());
    }
}
