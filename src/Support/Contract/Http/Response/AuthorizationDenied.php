<?php

namespace Plexikon\Auth\Support\Contract\Http\Response;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

interface AuthorizationDenied
{
    public function onAuthorizationDenied(Request $request, AuthorizationException $exception): Response;
}
