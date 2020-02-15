<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authorization;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthServiceFailure;
use Plexikon\Auth\Guard\Authorization\DefaultAuthorizationChecker;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Authenticatable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationStrategy;
use Plexikon\Auth\Test\Unit\TestCase;
use Prophecy\Argument;

class DefaultAuthorizationCheckerTest extends TestCase
{
    /**
     * @test
     */
    public function it_grant_access(): void
    {
        $subject = new \stdClass();

        $token = $this->prophesize(Tokenable::class);
        $token->isAuthenticated()->willReturn(true);
        $token = $token->reveal();

        $manager = $this->prophesize(Authenticatable::class)->reveal();

        $strategy = $this->prophesize(AuthorizationStrategy::class);
        $strategy->decide($token, ['foo'], $subject)->willReturn(true);

        $storage = $this->prophesize(TokenStorage::class);
        $alwaysAuth = false;

        $storage->getToken()->willReturn($token);

        $checker = new DefaultAuthorizationChecker($manager, $strategy->reveal(), $storage->reveal(), $alwaysAuth);

        $this->assertTrue($checker->isGranted(['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_deny_access(): void
    {
        $subject = new \stdClass();

        $token = $this->prophesize(Tokenable::class);
        $token->isAuthenticated()->willReturn(true);
        $token = $token->reveal();

        $manager = $this->prophesize(Authenticatable::class)->reveal();

        $strategy = $this->prophesize(AuthorizationStrategy::class);
        $strategy->decide($token, ['foo'], $subject)->willReturn(false);

        $storage = $this->prophesize(TokenStorage::class);
        $alwaysAuth = false;

        $storage->getToken()->willReturn($token);

        $checker = new DefaultAuthorizationChecker($manager, $strategy->reveal(), $storage->reveal(), $alwaysAuth);

        $this->assertTrue($checker->isNotGranted(['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_use_request_instance_as_subject_of_strategy(): void
    {
        $request = $this->prophesize(Request::class)->reveal();
        $subject = $request;

        $token = $this->prophesize(Tokenable::class);
        $token->isAuthenticated()->willReturn(true);
        $token = $token->reveal();

        $manager = $this->prophesize(Authenticatable::class)->reveal();

        $strategy = $this->prophesize(AuthorizationStrategy::class);
        $strategy->decide($token, ['foo'], Argument::is($subject))->shouldBeCalled();

        $storage = $this->prophesize(TokenStorage::class);
        $alwaysAuth = false;

        $storage->getToken()->willReturn($token);

        $checker = new DefaultAuthorizationChecker($manager, $strategy->reveal(), $storage->reveal(), $alwaysAuth);
        $checker->setRequest($request);

        $checker->isGranted(['foo'], null);
    }

    /**
     * @test
     */
    public function it_force_authentication_token_if_always_needed(): void
    {
        $alwaysAuth = true;
        $subject = new \stdClass();

        $token = $this->prophesize(Tokenable::class);
        $token->isAuthenticated()->willReturn(true);
        $token = $token->reveal();

        $manager = $this->prophesize(Authenticatable::class);
        $manager->authenticate($token)->willReturn($token);

        $strategy = $this->prophesize(AuthorizationStrategy::class);
        $strategy->decide($token, ['foo'], Argument::is($subject))->shouldBeCalled();

        $storage = $this->prophesize(TokenStorage::class);
        $storage->store($token)->shouldBeCalled();
        $storage->getToken()->willReturn($token);

        $checker = new DefaultAuthorizationChecker($manager->reveal(), $strategy->reveal(), $storage->reveal(), $alwaysAuth);

        $checker->isGranted(['foo'], $subject);
    }

    /**
     * @test
     */
    public function it_force_authentication_token_if_is_not_already_authenticated(): void
    {
        $alwaysAuth = false;
        $subject = new \stdClass();

        $token = $this->prophesize(Tokenable::class);
        $token->isAuthenticated()->willReturn(false);
        $token = $token->reveal();

        $manager = $this->prophesize(Authenticatable::class);
        $manager->authenticate($token)->willReturn($token);

        $strategy = $this->prophesize(AuthorizationStrategy::class);
        $strategy->decide($token, ['foo'], Argument::is($subject))->shouldBeCalled();

        $storage = $this->prophesize(TokenStorage::class);
        $storage->store($token)->shouldBeCalled();
        $storage->getToken()->willReturn($token);

        $checker = new DefaultAuthorizationChecker($manager->reveal(), $strategy->reveal(), $storage->reveal(), $alwaysAuth);

        $checker->isGranted(['foo'], $subject);
    }

    /**
     * @test
     */
    public function it_raise_exception_if_storage_is_empty(): void
    {
        $manager = $this->prophesize(Authenticatable::class)->reveal();
        $strategy = $this->prophesize(AuthorizationStrategy::class)->reveal();
        $storage = $this->prophesize(TokenStorage::class);
        $alwaysAuth = false;

        $this->expectException(AuthServiceFailure::class);
        $this->expectExceptionMessage('No token found in storage');

        $storage->getToken()->willReturn(null);

        $checker = new DefaultAuthorizationChecker($manager, $strategy, $storage->reveal(), $alwaysAuth);

        $checker->isGranted(['foo'], null);
    }
}
