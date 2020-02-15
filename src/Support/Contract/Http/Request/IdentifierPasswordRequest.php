<?php

namespace Plexikon\Auth\Support\Contract\Http\Request;

use Illuminate\Http\Request;
use Plexikon\Auth\Support\Contract\Value\Credential\ClearCredential;
use Plexikon\Auth\Support\Contract\Value\Identifier;

interface IdentifierPasswordRequest extends AuthenticationRequest
{
    /**
     * @param Request $request
     * @return Identifier
     */
    public function extractIdentifier(Request $request): Identifier;

    /**
     * @param Request $request
     * @return ClearCredential
     */
    public function extractPassword(Request $request): ClearCredential;
}
