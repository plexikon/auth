<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authorization;

interface Voters
{
    /**
     * @return iterable|Votable
     */
    public function current(): iterable;
}
