<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\CodeHandlers;

class RemoveTokensCodeHandler
{
    public function handle(string $code, callable $next, int ...$removedTokens): string
    {
        $code = collect(token_get_all($code))->reduce(
            /**
             * @param array<int, string>|string $token
             */
            function (string $carry, array|string $token) use ($removedTokens): string {
                if (\is_string($token)) {
                    return $carry.$token;
                }

                return $carry.$this->ignoreToken($token, $removedTokens);
            },
            ''
        );

        return $next($code);
    }

    protected function ignoreToken(array $token, array $removedTokens): string
    {
        [$id, $text] = $token;
        if (\in_array($id, $removedTokens, true)) {
            return '';
        }

        return $text;
    }
}
