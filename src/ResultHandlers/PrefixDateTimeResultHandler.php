<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\ResultHandlers;

class PrefixDateTimeResultHandler
{
    public function handle(string $result, callable $next): string
    {
        $result = '<span class="text-primary">'.now()->format('Y-m-d H:i:s').'</span><br>'.$result;

        return $next($result);
    }
}
