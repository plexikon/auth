<?php
declare(strict_types=1);

namespace Plexikon\Auth\Guard\Authentication;

use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Plexikon\Auth\Support\Contract\Guard\Authentication\TrustResolver;

final class GenericTrustResolver implements TrustResolver
{
    private string $anonymousInterface;
    private string $rememberedInterface;

    public function __construct(string $anonymousInterface, string $rememberedInterface)
    {
        if (!interface_exists($anonymousInterface) || !interface_exists($rememberedInterface)) {
            $message = 'Generic implementation of trust resolver accept token interface only';

            throw new \InvalidArgumentException($message);
        }

        $this->anonymousInterface = $anonymousInterface;
        $this->rememberedInterface = $rememberedInterface;
    }

    public function isFullyAuthenticated(?Tokenable $token): bool
    {
        return $token && !$this->isAnonymous($token) && !$this->isRemembered($token);
    }

    public function isRemembered(?Tokenable $token): bool
    {
        return $token instanceof $this->rememberedInterface;
    }

    public function isAnonymous(?Tokenable $token): bool
    {
        return $token instanceof $this->anonymousInterface;
    }
}
