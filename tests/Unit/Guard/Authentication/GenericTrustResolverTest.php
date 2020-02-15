<?php
declare(strict_types=1);

namespace Plexikon\Auth\Test\Unit\Guard\Authentication;

use InvalidArgumentException;
use Plexikon\Auth\Guard\Authentication\GenericTrustResolver;
use Plexikon\Auth\Guard\Authentication\Token\Token;
use Plexikon\Auth\Support\Contract\Firewall\Key\ContextKey;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Token\AnonymousToken;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Token\RecallerToken;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Value\Credential\Credential;
use Plexikon\Auth\Support\Contract\Value\Value;
use Plexikon\Auth\Test\Unit\TestCase;

class GenericTrustResolverTest extends TestCase
{
    /**
     * @test
     */
    public function it_assert_anonymous_token(): void
    {
        $trustResolver = new GenericTrustResolver(AnonymousToken::class, RecallerToken::class);

        $this->assertTrue($trustResolver->isAnonymous($this->anonymousToken()));
        $this->assertFalse($trustResolver->isFullyAuthenticated($this->anonymousToken()));
        $this->assertFalse($trustResolver->isRemembered($this->anonymousToken()));
    }

    /**
     * @test
     */
    public function it_assert_recaller_token(): void
    {
        $trustResolver = new GenericTrustResolver(AnonymousToken::class, RecallerToken::class);

        $this->assertTrue($trustResolver->isRemembered($this->recallerToken()));
        $this->assertFalse($trustResolver->isFullyAuthenticated($this->recallerToken()));
        $this->assertFalse($trustResolver->isAnonymous($this->recallerToken()));
    }

    /**
     * @test
     */
    public function it_assert_fully_authenticated_token(): void
    {
        $trustResolver = new GenericTrustResolver(AnonymousToken::class, RecallerToken::class);

        $this->assertTrue($trustResolver->isFullyAuthenticated($this->dummyToken()));
    }

    /**
     * @test
     */
    public function it_raise_exception_if_invalid_anonymous_token(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Generic implementation of trust resolver accept token interface only');

        new GenericTrustResolver('foo', RecallerToken::class);
    }

    /**
     * @test
     */
    public function it_raise_exception_if_invalid_recaller_token(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Generic implementation of trust resolver accept token interface only');

        new GenericTrustResolver(AnonymousToken::class, 'bar');
    }

    private function anonymousToken(): AnonymousToken
    {
        return new class() extends Token implements AnonymousToken {

            public function __construct()
            {
                parent::__construct();
            }

            public function getCredentials(): Credential
            {
                return new class implements Credential {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'foo';
                    }
                };
            }

            public function getFirewallKey(): ContextKey
            {
                return new class implements ContextKey {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'bar';
                    }
                };
            }
        };
    }

    private function recallerToken(): RecallerToken
    {
        return new class() extends Token implements RecallerToken {

            public function __construct()
            {
                parent::__construct();
            }

            public function getCredentials(): Credential
            {
                return new class implements Credential {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'foo';
                    }
                };
            }

            public function getFirewallKey(): ContextKey
            {
                return new class implements ContextKey {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'bar';
                    }
                };
            }
        };
    }

    private function dummyToken(): Tokenable
    {
        return new class() extends Token {

            public function __construct()
            {
                parent::__construct();
            }

            public function getCredentials(): Credential
            {
                return new class implements Credential {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'foo';
                    }
                };
            }

            public function getFirewallKey(): ContextKey
            {
                return new class implements ContextKey {
                    public function sameValueAs(Value $aValue): bool
                    {
                        return true;
                    }

                    public function getValue()
                    {
                        return 'bar';
                    }
                };
            }
        };
    }
}
