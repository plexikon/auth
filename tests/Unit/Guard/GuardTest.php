<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard;

use Illuminate\Contracts\Events\Dispatcher;
use Plexikon\Auth\Guard\Guard;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Authenticatable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TokenStorage;
use Plexikon\Auth\Support\Contract\Http\Response\Entrypoint;
use Plexikon\Auth\Test\Unit\TestCase;

class GuardTest extends TestCase
{
    /**
     * @test
     */
    public function it_authenticate_and_store_token(): void
    {
        $entrypoint = $this->prophesize(Entrypoint::class)->reveal();
        $dispatcher = $this->prophesize(Dispatcher::class)->reveal();
        $token = $this->prophesize(Tokenable::class)->reveal();
        $authToken = $this->prophesize(Tokenable::class)->reveal();

        $storage = $this->prophesize(TokenStorage::class);
        $manager = $this->prophesize(Authenticatable::class);

        $manager->authenticate($token)->willReturn($authToken);
        $storage->store($authToken)->shouldBeCalled();

        $guard = new Guard($storage->reveal(), $manager->reveal(), $entrypoint, $dispatcher);

        $authenticatedToken = $guard->storeAuthenticatedToken($token);

        $this->assertEquals($authToken, $authenticatedToken);
    }
}
