<?php

namespace Plexikon\Auth\Support\Contract\Guard\Authorization;

interface AuthorizationChecker
{
    public function isGranted(iterable $attributes, ?object $subject): bool;

    public function isNotGranted(iterable $attributes, ?object $subject): bool;
}
