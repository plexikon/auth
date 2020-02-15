<?php

namespace Plexikon\Auth\Support\Contract\Value;

interface Value
{
    /**
     * @param Value $aValue
     * @return bool
     */
    public function sameValueAs(Value $aValue): bool;

    /**
     * @return mixed
     */
    public function getValue();
}
