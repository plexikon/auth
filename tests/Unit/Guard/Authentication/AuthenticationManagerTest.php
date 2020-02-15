<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authentication;

use Plexikon\Auth\Exception\AuthServiceFailure;
use Plexikon\Auth\Guard\Authentication\AuthenticationManager;
use Plexikon\Auth\Support\Contract\Guard\Authentication\AuthenticationProvider;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Test\Unit\TestCase;

class AuthenticationManagerTest extends TestCase
{
    /**
     * @test
     */
    public function it_authenticate_token(): void
    {
        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneProvider = $this->prophesize(AuthenticationProvider::class);
        $oneProvider->supportToken($token)->willReturn(true);
        $oneProvider->authenticate($token)->willReturn($token);

        $authManager = new AuthenticationManager($oneProvider->reveal());

        $authToken = $authManager->authenticate($token);

        $this->assertEquals($token, $authToken);
    }

    /**
     * @test
     */
    public function it_raise_exception_if_no_authentication_provider_provided(): void
    {
        $this->expectException(AuthServiceFailure::class);
        $this->expectExceptionMessage('No authentication provider has been provided for Authentication manager');

        new AuthenticationManager();
    }

    /**
     * @test
     */
    public function it_raise_exception_if_no_authentication_provider_supports_token(): void
    {
        $this->expectException(AuthServiceFailure::class);
        $this->expectExceptionMessage('No authentication provider support token');

        $token = $this->prophesize(Tokenable::class)->reveal();

        $oneProvider = $this->prophesize(AuthenticationProvider::class);
        $oneProvider->supportToken($token)->willReturn(false);

        $authManager = new AuthenticationManager($oneProvider->reveal());

        $authManager->authenticate($token);
    }
}
