<?php

namespace Plexikon\Auth\Support\Contract\Http\Response;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthenticationException;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Symfony\Component\HttpFoundation\Response;

interface AuthenticationResponse
{
    public function onSuccess(Request $request, Tokenable $token): Response;

    public function onFailure(Request $request, AuthenticationException $exception): Response;
}
