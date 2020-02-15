<?php

namespace Plexikon\Auth\Support\Contract\Http\Middleware;

use Illuminate\Http\Request;
use Plexikon\Auth\Exception\AuthenticationException;
use Plexikon\Auth\Support\Contract\Guard\Authentication\Tokenable;

interface AuthenticationEventGuard
{
    /**
     * Dispatch attempt login event
     *
     * @param Request $request
     * @param Tokenable $token
     */
    public function fireAttemptLoginEvent(Request $request, Tokenable $token): void;

    /**
     * Dispatch success login event
     *
     * @param Request $request
     * @param Tokenable $token
     */
    public function fireSuccessLoginEvent(Request $request, Tokenable $token): void;

    /**
     * Dispatch failure login event
     *
     * @param Request $request
     * @param AuthenticationException $exception
     */
    public function fireFailureLoginEvent(Request $request, AuthenticationException $exception): void;
}
