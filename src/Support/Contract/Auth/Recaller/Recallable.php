<?php

namespace Plexikon\Auth\Support\Contract\Auth\Recaller;

use Illuminate\Http\Request;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;
use Symfony\Component\HttpFoundation\Response;

interface Recallable
{
    public function autoLogin(Request $request): ?Tokenable;

    public function loginFail(Request $request): void;

    public function loginSuccess(Request $request, Response $response, Tokenable $token): void;
}
