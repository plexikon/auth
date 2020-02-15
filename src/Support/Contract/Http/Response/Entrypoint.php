<?php

namespace Plexikon\Auth\Support\Contract\Http\Response;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

interface Entrypoint
{
    public function startAuthentication(Request $request, ?AuthenticationException $exception = null): Response;
}
