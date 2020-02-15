<?php

namespace Plexikon\Auth\Support\Contract\Auth\Logout;

use Illuminate\Http\Request;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Symfony\Component\HttpFoundation\Response;

interface Logout
{
    public function logout(Request $request, Tokenable $token, Response $response): void;
}
