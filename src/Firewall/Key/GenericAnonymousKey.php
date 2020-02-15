<?php
declare(strict_types=1);

namespace Plexikon\Auth\Firewall\Key;

use Assert\Assert;
use Plexikon\Auth\Support\Contract\Firewall\Key\AnonymousKey;
use Plexikon\Auth\Support\Contract\Value\Value;

class GenericAnonymousKey implements AnonymousKey
{
    private string $key;

    public function __construct($key)
    {
        Assert::that($key , 'firewall anonymous key is invalid')->notBlank()->string();

        $this->key = $key;
    }

    public function sameValueAs(Value $aValue): bool
    {
        return get_class($aValue) === get_class($this)
            && $this->getValue() === $aValue->getValue();
    }

    public function getValue(): string
    {
        return $this->key;
    }
}
