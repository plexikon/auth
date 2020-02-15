<?php

namespace Plexikon\Auth\Support\Contract\Http\Middleware;

use Plexikon\Auth\Support\Contract\Auth\Recaller\Recallable;

interface StatefulAuthentication extends Authentication
{
    public function setRecallerService(Recallable $recallerService): void;
}
