<?php

namespace Plexikon\Auth\Support\Contract\Http\Response;

use Illuminate\Http\Request;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Symfony\Component\HttpFoundation\Response;

interface LogoutResponse
{
    public function onLogout(Request $request, Tokenable $token): Response;
}
