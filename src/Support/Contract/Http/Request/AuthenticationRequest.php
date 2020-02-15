<?php

namespace Plexikon\Auth\Support\Contract\Http\Request;

use Illuminate\Http\Request;

interface AuthenticationRequest
{
    /**
     * Extract Identifier from Request
     *
     * @param Request $request
     * @return bool
     */
    public function match(Request $request): bool;

    /**
     * Extract credentials from request
     *
     * @param Request $request
     * @return mixed
     */
    public function extractCredentials(Request $request);
}
