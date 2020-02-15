<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authorization\Voter;

use Plexikon\Auth\Guard\Authorization\Strategy\AffirmativeAuthorizationStrategy;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Votable;
use Plexikon\Auth\Support\Contract\Guard\Authorization\Voters;
use Plexikon\Auth\Test\Unit\TestCase;

class AffirmativeAuthorizationStrategyTest extends TestCase
{
    /**
     * @test
     */
    public function it_grant_vote(): void
    {
        $allowIfAllAbstain = false;
        $subject = new \stdClass();
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneVoter = $this->prophesize(Votable::class);
        $oneVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_GRANTED);
        $oneVoter = $oneVoter->reveal();

        $voters = $this->prophesize(Voters::class);
        $voters->current()->willYield([$oneVoter]);

        $auth = new AffirmativeAuthorizationStrategy($voters->reveal(), $allowIfAllAbstain);

        $this->assertTrue($auth->decide($token, ['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_deny_vote(): void
    {
        $allowIfAllAbstain = false;
        $subject = new \stdClass();
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneVoter = $this->prophesize(Votable::class);
        $oneVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_DENIED);
        $oneVoter = $oneVoter->reveal();

        $voters = $this->prophesize(Voters::class);
        $voters->current()->willYield([$oneVoter]);

        $auth = new AffirmativeAuthorizationStrategy($voters->reveal(), $allowIfAllAbstain);

        $this->assertFalse($auth->decide($token, ['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_grant_access_on_first_positive_voter(): void
    {
        $allowIfAllAbstain = false;
        $subject = new \stdClass();
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneDeniedVoter = $this->prophesize(Votable::class);
        $oneDeniedVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_DENIED);
        $oneDeniedVoter = $oneDeniedVoter->reveal();

        $onePositiveVoter = $this->prophesize(Votable::class);
        $onePositiveVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_GRANTED);
        $onePositiveVoter = $onePositiveVoter->reveal();

        $unTouchedVoter = $this->prophesize(Votable::class);
        $unTouchedVoter->vote()->shouldNotBeCalled();


        $voters = $this->prophesize(Voters::class);
        $voters->current()->willYield([$oneDeniedVoter, $onePositiveVoter, $unTouchedVoter]);

        $auth = new AffirmativeAuthorizationStrategy($voters->reveal(), $allowIfAllAbstain);

        $this->assertTrue($auth->decide($token, ['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_grant_access_if_all_abstain(): void
    {
        $allowIfAllAbstain = true;
        $subject = new \stdClass();
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneAbstainVoter = $this->prophesize(Votable::class);
        $oneAbstainVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_ABSTAIN);
        $oneAbstainVoter = $oneAbstainVoter->reveal();


        $voters = $this->prophesize(Voters::class);
        $voters->current()->willYield([$oneAbstainVoter]);

        $auth = new AffirmativeAuthorizationStrategy($voters->reveal(), $allowIfAllAbstain);

        $this->assertTrue($auth->decide($token, ['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_deny_access_if_all_abstain(): void
    {
        $allowIfAllAbstain = false;
        $subject = new \stdClass();
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneAbstainVoter = $this->prophesize(Votable::class);
        $oneAbstainVoter->vote($token, ['foo'], $subject)->willReturn(Votable::ACCESS_ABSTAIN);
        $oneAbstainVoter = $oneAbstainVoter->reveal();


        $voters = $this->prophesize(Voters::class);
        $voters->current()->willYield([$oneAbstainVoter]);

        $auth = new AffirmativeAuthorizationStrategy($voters->reveal(), $allowIfAllAbstain);

        $this->assertFalse($auth->decide($token, ['foo'], $subject));
    }
}
