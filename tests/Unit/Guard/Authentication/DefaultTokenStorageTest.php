<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authentication;

use Plexikon\Auth\Guard\Authentication\DefaultTokenStorage;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Test\Unit\TestCase;

class DefaultTokenStorageTest extends TestCase
{
    /**
     * @test
     */
    public function it_construct_with_empty_storage(): void
    {
        $storage = new DefaultTokenStorage();

        $this->assertNull($storage->getToken());
    }

    /**
     * @test
     */
    public function it_store_token(): void
    {
        $storage = new DefaultTokenStorage();

        $token = $this->prophesize(Tokenable::class)->reveal();
        $this->assertNull($storage->getToken());

        $storage->store($token);
        $this->assertEquals($token, $storage->getToken());
    }

    /**
     * @test
     */
    public function it_clear_storage(): void
    {
        $storage = new DefaultTokenStorage();

        $token = $this->prophesize(Tokenable::class)->reveal();
        $this->assertNull($storage->getToken());

        $storage->store($token);
        $this->assertEquals($token, $storage->getToken());

        $storage->clear();
        $this->assertNull($storage->getToken());
    }

    /**
     * @test
     */
    public function it_clear_storage_with_null_token(): void
    {
        $storage = new DefaultTokenStorage();

        $token = $this->prophesize(Tokenable::class)->reveal();
        $this->assertNull($storage->getToken());

        $storage->store($token);
        $this->assertEquals($token, $storage->getToken());

        $storage->store(null);
        $this->assertNull($storage->getToken());
    }

    /**
     * @test
     */
    public function it_assert_storage_is_empty(): void
    {
        $storage = new DefaultTokenStorage();

        $this->assertTrue($storage->isEmpty());
    }

    /**
     * @test
     */
    public function it_assert_storage_is_not_empty(): void
    {
        $storage = new DefaultTokenStorage();

        $token = $this->prophesize(Tokenable::class)->reveal();
        $this->assertNull($storage->getToken());

        $storage->store($token);

        $this->assertEquals($token, $storage->getToken());
        $this->assertTrue($storage->isNotEmpty());
    }
}
