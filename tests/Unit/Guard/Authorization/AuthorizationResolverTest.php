<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authorization;

use Illuminate\Container\Container;
use Plexikon\Auth\Guard\Authorization\AuthorizationResolver;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Authorization\AuthorizationChecker;
use Plexikon\Auth\Test\Unit\TestCase;

class AuthorizationResolverTest extends TestCase
{
    /**
     * @test
     */
    public function it_resolve_authorization_strategy(): void
    {
        $subject = new \stdClass();

        $c = new Container();

        $checker = $this->prophesize(AuthorizationChecker::class);
        $checker->isGranted(['foo'], $subject)->willReturn(true);
        $checker = $checker->reveal();

        $c->instance(AuthorizationChecker::class, $checker);

        $resolver = new AuthorizationResolver($c);

        $this->assertTrue($resolver->isGranted(['foo'], $subject));
    }

    /**
     * @test
     */
    public function it_resolve_token_storage(): void
    {
        $token = $this->prophesize(Tokenable::class)->reveal();

        $c = new Container();

        $storage = $this->prophesize(TokenStorage::class);
        $storage->getToken()->willReturn($token);
        $storage = $storage->reveal();

        $c->instance(TokenStorage::class, $storage);

        $resolver = new AuthorizationResolver($c);

        $this->assertEquals($token, $resolver->getToken());
    }
}
